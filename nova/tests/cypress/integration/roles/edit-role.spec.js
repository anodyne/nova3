describe('Editing a role', () => {
    it('can navigate to edit role page from roles index page', () => {
        cy.loginWithPermissions({ permissions: 'role.update' });
        cy.visit('/roles');

        cy.get('main').within(() => {
            cy.get('[data-cy=dropdown-trigger]').first().click();
            cy.get('[data-cy=edit]').click();

            cy.url().should('match', /roles\/\d*\/edit/);
        });
    });

    context('Updating', () => {
        it('requires a name to update a role', () => {
            cy.loginWithPermissions({ permissions: 'role.update' });
            cy.visit('/roles/2/edit');

            cy.get('[data-cy=display_name]').clear();
            cy.get('[data-cy=form]').submit();

            cy.contains('The name field is required');
        });

        it('requires a role key to create a new role', () => {
            cy.loginWithPermissions({ permissions: 'role.update' });
            cy.visit('/roles/2/edit');

            cy.get('[data-cy=name]').clear();
            cy.get('[data-cy=form]').submit();

            cy.contains('The key field is required');
        });
    });

    context('Permissions', () => {
        it('can see the edit button when user has permissions', () => {
            cy.loginWithPermissions({ permissions: 'role.update' });
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=edit]');
            });
        });

        it('cannot see the edit button when user is missing permissions', () => {
            cy.loginWithPermissions({ permissions: 'role.create' });
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.contains('Edit').should('not.exist');
            });
        });
    });
});
