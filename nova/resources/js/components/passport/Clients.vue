<template>
  <div>
    <app-card>
      <template slot="card-header">
        <div class="card-title">OAuth Clients</div>

        <a class="button is-primary" 
tabindex="-1" @click="showCreateClientForm">
          <icon name="add" 
class="btn-icon"/>
          <span>Create New Client</span>
        </a>
      </template>

      <template v-show="clients.length == 0" slot="card-content">
        <p class="font-medium mb-0">
          You have not created any OAuth clients.
        </p>
      </template>

      <template v-show="clients.length > 0" slot="card-block">
        <div class="data-table has-controls in-card is-rounded-bottom">
          <div class="row is-header">
            <div class="col-2">Client ID</div>
            <div class="col-4">Name</div>
            <div class="col-5">Secret</div>
            <div class="col-1">&nbsp;</div>
          </div>

          <div v-for="client in filteredClients" class="row" :key="client.id">
            <div class="col-2">{{ client.id }}</div>
            <div class="col-4">{{ client.name }}</div>
            <div class="col-5">
              <code class="font-mono text-xs text-primary-dark">
                {{ client.secret }}
              </code>
            </div>
            <div class="col-1 row-controls">
              <!--<nova-dropdown :is-inverted="false" direction="right">
								<template slot="trigger">
									<button type="button"
											class="button is-flush"
											data-toggle="dropdown"
											aria-haspopup="true"
											aria-expanded="false"
									>
										<icon name="more" class="btn-icon"></icon>
									</button>
								</template>

								<a slot="items" class="dropdown-item" @click="edit(client)">Edit</a>
								<a slot="items" class="dropdown-item is-danger" @click="destroy(client)">Delete</a>
							</nova-dropdown>-->
            </div>
          </div>
        </div>
      </template>
    </app-card>

    <!-- Create Client Modal -->
    <div id="modal-create-client" class="hidden modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">
              Create Client
            </h4>

            <button type="button" 
class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>

          <div class="modal-body">
            <!-- Form Errors -->
            <div v-if="createForm.errors.length > 0" class="alert alert-danger">
              <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
              <br>
              <ul>
                <li v-for="error in createForm.errors">
                  {{ error }}
                </li>
              </ul>
            </div>

            <!-- Create Client Form -->
            <form role="form">
              <!-- Name -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label">Name</label>

                <div class="col-md-9">
                  <input 
id="create-client-name" 
type="text" class="form-control"
                         @keyup.enter="store" 
v-model="createForm.name"
>

                  <span class="form-text text-muted">
                    Something your users will recognize and trust.
                  </span>
                </div>
              </div>

              <!-- Redirect URL -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label">Redirect URL</label>

                <div class="col-md-9">
                  <input 
type="text" 
class="form-control" name="redirect"
                         @keyup.enter="store" 
v-model="createForm.redirect"
>

                  <span class="form-text text-muted">
                    Your application's authorization callback URL.
                  </span>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Actions -->
          <div class="modal-footer">
            <button type="button" 
class="btn btn-secondary" data-dismiss="modal">Close</button>

            <button type="button" 
class="btn btn-primary" @click="store">
              Create
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Client Modal -->
    <div id="modal-edit-client" class="hidden modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">
              Edit Client
            </h4>

            <button type="button" 
class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>

          <div class="modal-body">
            <!-- Form Errors -->
            <div v-if="editForm.errors.length > 0" class="alert alert-danger">
              <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
              <br>
              <ul>
                <li v-for="error in editForm.errors">
                  {{ error }}
                </li>
              </ul>
            </div>

            <!-- Edit Client Form -->
            <form role="form">
              <!-- Name -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label">Name</label>

                <div class="col-md-9">
                  <input 
id="edit-client-name" 
type="text" class="form-control"
                         @keyup.enter="update" 
v-model="editForm.name"
>

                  <span class="form-text text-muted">
                    Something your users will recognize and trust.
                  </span>
                </div>
              </div>

              <!-- Redirect URL -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label">Redirect URL</label>

                <div class="col-md-9">
                  <input 
type="text" 
class="form-control" name="redirect"
                         @keyup.enter="update" 
v-model="editForm.redirect"
>

                  <span class="form-text text-muted">
                    Your application's authorization callback URL.
                  </span>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Actions -->
          <div class="modal-footer">
            <button type="button" 
class="btn btn-secondary" data-dismiss="modal">Close</button>

            <button type="button" 
class="btn btn-primary" @click="update">
              Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from '../Dropdown.vue';

export default {
    components: { Dropdown },

    /*
         * The component's data.
         */
    data() {
        return {
            clients: [],

            createForm: {
                errors: [],
                name: '',
                redirect: '',
            },

            editForm: {
                errors: [],
                name: '',
                redirect: '',
            },
        };
    },

    computed: {
        filteredClients() {
            return _.sortBy(this.clients, client => client.id);
        },
    },

    /**
         * Prepare the component (Vue 1.x).
         */
    ready() {
        this.prepareComponent();
    },

    /**
         * Prepare the component (Vue 2.x).
         */
    mounted() {
        this.prepareComponent();
    },

    methods: {
        /**
             * Prepare the component.
             */
        prepareComponent() {
            this.getClients();

            $('#modal-create-client').on('shown.bs.modal', () => {
                $('#create-client-name').focus();
            });

            $('#modal-edit-client').on('shown.bs.modal', () => {
                $('#edit-client-name').focus();
            });
        },

        /**
             * Get all of the OAuth clients for the user.
             */
        getClients() {
            axios.get('/oauth/clients')
                .then((response) => {
                    this.clients = response.data;
                });
        },

        /**
             * Show the form for creating new clients.
             */
        showCreateClientForm() {
            $('#modal-create-client').modal('show');
        },

        /**
             * Create a new OAuth client for the user.
             */
        store() {
            this.persistClient(
                'post', '/oauth/clients',
                this.createForm, '#modal-create-client',
            );
        },

        /**
             * Edit the given client.
             */
        edit(client) {
            this.editForm.id = client.id;
            this.editForm.name = client.name;
            this.editForm.redirect = client.redirect;

            $('#modal-edit-client').modal('show');
        },

        /**
             * Update the client being edited.
             */
        update() {
            this.persistClient(
                'put', `/oauth/clients/${  this.editForm.id}`,
                this.editForm, '#modal-edit-client',
            );
        },

        /**
             * Persist the client to storage using the given form.
             */
        persistClient(method, uri, form, modal) {
            form.errors = [];

            axios[method](uri, form)
                .then((response) => {
                    this.getClients();

                    form.name = '';
                    form.redirect = '';
                    form.errors = [];

                    $(modal).modal('hide');
                })
                .catch((error) => {
                    if (typeof error.response.data === 'object') {
                        form.errors = _.flatten(_.toArray(error.response.data.errors));
                    } else {
                        form.errors = ['Something went wrong. Please try again.'];
                    }
                });
        },

        /**
             * Destroy the given client.
             */
        destroy(client) {
            axios.delete(`/oauth/clients/${  client.id}`)
                .then((response) => {
                    this.getClients();
                });
        },
    },
};
</script>
