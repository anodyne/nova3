<template>
    <div>
        <app-card>
            <template slot="card-header">
                <div class="card-title">Personal Access Tokens</div>

                <a
                    class="button is-primary"
                    tabindex="-1"
                    @click="showCreateTokenForm"
                >
                    <icon
                        name="add"
                        class="btn-icon"
                    />
                    <span>Create New Token</span>
                </a>
            </template>

            <template
                v-if="tokens.length == 0"
                slot="card-content"
            >
                <div class="rounded px-6 py-12 border border-grey-lighter -mb-6 flex flex-col bg-grey-lightest">
                    <div class="flex items-center font-medium text-grey-darker mb-6">
                        <icon
                            name="info"
                            class="mr-3 text-primary-light"
                        />
                        <div>You have not created any personal access tokens.</div>
                    </div>
                    <div class="text-grey-dark text-sm leading-loose">
                        A personal access token is another way to authorize access to the Nova API. Personal access tokens don't require going through the normal OAuth user authorization process, so they're a great option if you want to test out Nova's API in a tool like <a
                            href="https://www.getpostman.com"
                            target="_blank"
                            class="inline-flex items-center"
                        >Postman <icon
                            name="external"
                            class="ml-1 h-3 w-3"
                        /></a> or do some development work.
                    </div>
                </div>
            </template>

            <template
                v-if="tokens.length > 0"
                slot="card-block"
            >
                <div class="data-table in-card is-rounded-bottom">
                    <div class="row is-header">
                        <div class="col">Name</div>
                    </div>

                    <div
                        v-for="token in tokens"
                        :key="token.id"
                        class="row"
                    >
                        <div class="col">{{ token.name }}</div>
                        <div class="col-auto">
                            <a
                                class="btn btn-danger"
                                @click="revoke(token)"
                            >
                                <icon
                                    name="close-alt"
                                    class="btn-icon"
                                />
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </app-card>

        <!-- Create Token Modal -->
        <div
            id="modal-create-token"
            class="hidden modal fade"
            tabindex="-1"
            role="dialog"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Create Token
                        </h4>

                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-hidden="true"
                        >&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div
                            v-if="form.errors.length > 0"
                            class="alert alert-danger"
                        >
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li
                                    v-for="error in form.errors"
                                    :key="error"
                                >
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Token Form -->
                        <form
                            role="form"
                            @submit.prevent="store"
                        >
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Name</label>

                                <div class="col-md-6">
                                    <input
                                        id="create-token-name"
                                        v-model="form.name"
                                        type="text"
                                        class="form-control"
                                        name="name"
                                    >
                                </div>
                            </div>

                            <!-- Scopes -->
                            <div
                                v-if="scopes.length > 0"
                                class="form-group row"
                            >
                                <label class="col-md-4 col-form-label">Scopes</label>

                                <div class="col-md-6">
                                    <div
                                        v-for="scope in scopes"
                                        :key="scope.id"
                                    >
                                        <div class="checkbox">
                                            <label>
                                                <input
                                                    :checked="scopeIsAssigned(scope.id)"
                                                    type="checkbox"
                                                    @click="toggleScope(scope.id)"
                                                >

                                                {{ scope.id }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >Close</button>

                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="store"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Access Token Modal -->
        <div
            id="modal-access-token"
            class="hidden modal fade"
            tabindex="-1"
            role="dialog"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Personal Access Token
                        </h4>

                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-hidden="true"
                        >&times;</button>
                    </div>

                    <div class="modal-body">
                        <p>
                            Here is your new personal access token. This is the only time it will be shown so don't lose it!
                            You may now use this token to make API requests.
                        </p>

                        <textarea
                            class="form-control"
                            rows="10"
                        >{{ accessToken }}</textarea>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    /*
         * The component's data.
         */
    data () {
        return {
            accessToken: null,

            tokens: [],
            scopes: [],

            form: {
                name: '',
                scopes: [],
                errors: []
            }
        };
    },

    /**
         * Prepare the component (Vue 1.x).
         */
    ready () {
        this.prepareComponent();
    },

    /**
         * Prepare the component (Vue 2.x).
         */
    mounted () {
        this.prepareComponent();
    },

    methods: {
        /**
             * Prepare the component.
             */
        prepareComponent () {
            this.getTokens();
            this.getScopes();

            $('#modal-create-token').on('shown.bs.modal', () => {
                $('#create-token-name').focus();
            });
        },

        /**
             * Get all of the personal access tokens for the user.
             */
        getTokens () {
            Nova.request().get('/oauth/personal-access-tokens')
                .then((response) => {
                    this.tokens = response.data;
                });
        },

        /**
             * Get all of the available scopes.
             */
        getScopes () {
            Nova.request().get('/oauth/scopes')
                .then((response) => {
                    this.scopes = response.data;
                });
        },

        /**
             * Show the form for creating new tokens.
             */
        showCreateTokenForm () {
            $('#modal-create-token').modal('show');
        },

        /**
             * Create a new personal access token.
             */
        store () {
            this.accessToken = null;

            this.form.errors = [];

            Nova.request().post('/oauth/personal-access-tokens', this.form)
                .then((response) => {
                    this.form.name = '';
                    this.form.scopes = [];
                    this.form.errors = [];

                    this.tokens.push(response.data.token);

                    this.showAccessToken(response.data.accessToken);
                })
                .catch((error) => {
                    if (typeof error.response.data === 'object') {
                        this.form.errors = _.flatten(_.toArray(error.response.data.errors));
                    } else {
                        this.form.errors = ['Something went wrong. Please try again.'];
                    }
                });
        },

        /**
             * Toggle the given scope in the list of assigned scopes.
             */
        toggleScope (scope) {
            if (this.scopeIsAssigned(scope)) {
                this.form.scopes = _.reject(this.form.scopes, (s) => {
                    return s === scope;
                });
            } else {
                this.form.scopes.push(scope);
            }
        },

        /**
             * Determine if the given scope has been assigned to the token.
             */
        scopeIsAssigned (scope) {
            return _.indexOf(this.form.scopes, scope) >= 0;
        },

        /**
             * Show the given access token to the user.
             */
        showAccessToken (accessToken) {
            $('#modal-create-token').modal('hide');

            this.accessToken = accessToken;

            $('#modal-access-token').modal('show');
        },

        /**
             * Revoke the given token.
             */
        revoke (token) {
            Nova.request().delete(`/oauth/personal-access-tokens/${token.id}`)
                .then(() => {
                    this.getTokens();
                });
        }
    }
};
</script>
