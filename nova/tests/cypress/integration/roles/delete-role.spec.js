describe('Deleting a role', () => {
    it('can delete a role', () => {
        cy.create('Nova-Roles-Models-Role').then((role) => {
            cy.loginWithPermissions({ permissions: 'role.delete' });
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.contains(role.display_name).parent().within(() => {
                    cy.get('[data-cy=dropdown-trigger]').first().click();
                    cy.get('[data-cy=delete]').click();
                });
            });

            cy.get('[data-cy=modal]');
            cy.get('[data-cy=modal-title]').should('contain', 'Delete Role');
            cy.get('[data-cy=delete-role]').click();

            cy.get('[data-cy=modal]').should('not.exist');

            cy.get('main').within(() => {
                cy.contains(role.display_name).should('not.exist');
            });
        });
    });

    context('Testing system permissions', () => {
        it('can see the delete button when user has permissions', () => {
            cy.loginWithPermissions({ permissions: 'role.delete' });
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=delete]');
            });
        });

        it('cannot see the delete button when user is missing permissions', () => {
            cy.loginWithPermissions({ permissions: 'role.create' });
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=delete]').should('not.exist');
            });
        });
    });
});
