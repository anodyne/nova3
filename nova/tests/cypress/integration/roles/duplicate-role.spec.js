describe('Duplicating a role', () => {
    it('can duplicate a role', () => {
        cy.loginWithPermissions({ permissions: ['role.create', 'role.update'] });
        cy.visit('/roles');

        cy.get('main').within(() => {
            cy.get('[data-cy=dropdown-trigger]').first().click();
            cy.get('[data-cy=duplicate]').click();

            cy.url().should('match', /roles\/\d*\/edit/);
        });
    });

    context('Testing system permissions', () => {
        it('can see the duplicate button when user has permissions', () => {
            cy.loginWithPermissions({ permissions: ['role.create', 'role.update'] });
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=duplicate]');
            });
        });

        it('cannot see the duplicate button when user is missing permissions', () => {
            cy.loginWithPermissions({ permissions: 'role.create' });
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=duplicate]').should('not.exist');
            });
        });
    });
});
