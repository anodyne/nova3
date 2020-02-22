describe('Creating a user', () => {
    beforeEach(() => {
        cy.loginWithPermissions({ permissions: 'user.create' });
    });

    it('can navigate to create user page from users index page', () => {
        cy.visit('/users');

        cy.get('main').within(() => {
            cy.get('[data-cy=create]').click();
        });

        cy.url().should('match', /users\/create/);
    });

    it('can create a user', () => {
        cy.visit('/users/create');

        cy.get('[data-cy=name]').type('aaa');
        cy.get('[data-cy=email]').type('john1@example.com');
        cy.get('[data-cy=gender]').first().click();

        cy.get('[data-cy=tags-search]').first().type('user');
        cy.get('[data-cy=tags-search-results-item]').first().click();

        cy.get('[data-cy=form]').submit();

        cy.url().should('match', /users/);
        cy.contains('aaa');
    });

    context('Adding attributes', () => {
        beforeEach(() => {
            cy.visit('/users/create');
        });

        it('requires a name to create a user', () => {
            cy.get('[data-cy=name]');
            cy.get('[data-cy=form]').submit();

            cy.contains('The name field is required');
        });

        it('requires an email to create a user', () => {
            cy.get('[data-cy=name]').type('John');
            cy.get('[data-cy=form]').submit();

            cy.contains('The email field is required');
        });

        it('requires a selected pronoun to create a user', () => {
            cy.get('[data-cy=name]').type('John');
            cy.get('[data-cy=email]').type('john@example.com');
            cy.get('[data-cy=form]').submit();

            cy.contains('Please select from one of the available pronouns');
        });
    });

    context('Attaching roles', () => {
        beforeEach(() => {
            cy.visit('/users/create');
        });

        it('can search for roles', () => {
            cy.get('[data-cy=tags-search]').first().type('user');

            cy.get('[data-cy=tags-search-results]');
            cy.contains('Basic User');
        });

        it('can select a role to add to the user', () => {
            cy.get('[data-cy=tags-search]').first().type('user');

            cy.get('[data-cy=tags-search-results]');
            cy.get('[data-cy=tags-search-results-item]').first().click();

            cy.get('[data-cy=tags-search-results]').should('not.exist');
            cy.get('[data-cy=tag-item]').should('contain', 'Basic User');
        });

        it('can remove a selected role from the list', () => {
            cy.get('[data-cy=tags-search]').first().type('user');
            cy.get('[data-cy=tags-search-results-item]').first().click();
            cy.get('[data-cy=remove-tag-item]').first().click();

            cy.get('[data-cy=tag-item]').should('not.contain', 'Basic User');
        });

        it('can clear role search results', () => {
            cy.get('[data-cy=tags-search]').first().type('user');

            cy.get('[data-cy=tags-search-results]');
            cy.get('[data-cy=reset-tags-search]').click();
            cy.get('[data-cy=tags-search-results]').should('not.exist');
        });
    });

    context('Testing system permissions', () => {
        it('can see the create button when user has permissions', () => {
            cy.visit('/users');

            cy.get('main').within(() => {
                cy.get('[data-cy=create]');
            });
        });

        it('cannot see the create button when user is missing permissions', () => {
            cy.logout();
            cy.loginWithPermissions({ permissions: 'user.update' });
            cy.visit('/users');

            cy.get('main').within(() => {
                cy.get('[data-cy=create]').should('not.exist');
            });
        });
    });
});
