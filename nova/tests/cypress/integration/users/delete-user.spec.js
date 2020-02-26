describe('Deleting a user', () => {
    it('can delete a user', () => {
        cy.create('Nova-Users-Models-User', { name: 'bbb' }).then((user) => {
            cy.loginWithPermissions({ permissions: 'user.delete' });
            cy.visit('/users');

            cy.get('main').within(() => {
                cy.contains(user.name).parent().parent().within(() => {
                    cy.get('[data-cy=dropdown-trigger]').first().click();
                    cy.get('[data-cy=delete]').click();
                });
            });

            cy.get('[data-cy=modal]');
            cy.get('[data-cy=modal-title]').should('contain', 'Delete Account');
            cy.get('[data-cy=delete-user]').click();

            cy.get('[data-cy=modal]').should('not.exist');

            cy.get('main').within(() => {
                cy.contains(user.name).should('not.exist');
            });
        });
    });

    context('Testing system permissions', () => {
        it('can see the delete button when user has permissions', () => {
            cy.loginWithPermissions({ permissions: 'user.delete' });
            cy.visit('/users');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=delete]');
            });
        });

        it('cannot see the delete button when user is missing permissions', () => {
            cy.loginWithPermissions({ permissions: 'user.create' });
            cy.visit('/users');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=delete]').should('not.exist');
            });
        });
    });
});
