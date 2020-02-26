describe('Editing a role', () => {
    beforeEach(() => {
        cy.loginWithPermissions({ permissions: 'role.update' });
    });

    it('can navigate to edit role page from roles index page', () => {
        cy.visit('/roles');

        cy.get('main').within(() => {
            cy.get('[data-cy=dropdown-trigger]').first().click();
            cy.get('[data-cy=edit]').click();
        });

        cy.url().should('match', /roles\/\d*\/edit/);
    });

    it('can update a role', () => {
        cy.visit('/roles/2/edit');

        cy.get('[data-cy=display_name]').clear().type('Standard User');
        cy.get('[data-cy=form]').submit();

        cy.url().should('match', /roles/);
        cy.contains('Standard User');
    });

    context('Updating attributes', () => {
        beforeEach(() => {
            cy.visit('/roles/2/edit');
        });

        it('requires a name to update a role', () => {
            cy.get('[data-cy=display_name]').clear();
            cy.get('[data-cy=form]').submit();

            cy.contains('The name field is required');
        });

        it('requires a key to update a role', () => {
            cy.get('[data-cy=name]').clear();
            cy.get('[data-cy=form]').submit();

            cy.contains('The key field is required');
        });
    });

    context('Attaching permissions', () => {
        beforeEach(() => {
            cy.visit('/roles/2/edit');
        });

        it('can search for permissions', () => {
            cy.get('[data-cy=tags-search]').first().type('create');

            cy.get('[data-cy=tags-search-results]');
            cy.contains('Create user');
        });

        it('can select a permission to add to the role', () => {
            cy.get('[data-cy=tags-search]').first().type('create');

            cy.get('[data-cy=tags-search-results]');
            cy.get('[data-cy=tags-search-results-item]').first().click();

            cy.get('[data-cy=tags-search-results]').should('not.exist');
            cy.get('[data-cy=tag-item]').should('contain', 'Create');
        });

        it('can remove a selected permission from the list', () => {
            cy.get('[data-cy=tags-search]').first().type('create');
            cy.get('[data-cy=tags-search-results-item]').first().click();
            cy.get('[data-cy=remove-tag-item]').first().click();

            cy.get('[data-cy=tag-item]').should('not.contain', 'Create');
        });

        it('can clear permission search results', () => {
            cy.get('[data-cy=tags-search]').first().type('create');

            cy.get('[data-cy=tags-search-results]');
            cy.get('[data-cy=reset-tags-search]').click();
            cy.get('[data-cy=tags-search-results]').should('not.exist');
        });
    });

    context('Assigning users', () => {
        beforeEach(() => {
            cy.visit('/roles/2/edit');
        });

        it('can search for users', () => {
            cy.create('Nova-Users-Models-User').then((user) => {
                cy.get('[data-cy=tags-search]').last().type(user.name);

                cy.get('[data-cy=tags-search-results]');
                cy.contains(user.name);
            });
        });

        it('can select a user to assign to the role', () => {
            cy.create('Nova-Users-Models-User').then((user) => {
                cy.get('[data-cy=tags-search]').last().type(user.name);

                cy.get('[data-cy=tags-search-results]');
                cy.get('[data-cy=tags-search-results-item]').first().click();
                cy.get('[data-cy=tags-search-results]').should('not.exist');
                cy.get('[data-cy=tag-item]').should('contain', user.name);
            });
        });

        it('can clear user search results', () => {
            cy.create('Nova-Users-Models-User').then((user) => {
                cy.get('[data-cy=tags-search]').last().type(user.name);

                cy.get('[data-cy=tags-search-results]');
                cy.get('[data-cy=reset-tags-search]').click();
                cy.get('[data-cy=tags-search-results]').should('not.exist');
            });
        });
    });

    context('Testing system permissions', () => {
        it('can see the edit button when user has permissions', () => {
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=edit]');
            });
        });

        it('cannot see the edit button when user is missing permissions', () => {
            cy.logout();
            cy.loginWithPermissions({ permissions: 'role.create' });
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=edit]').should('not.exist');
            });
        });
    });
});
