describe('Viewing a role', () => {
    it('can navigate to the view role page', () => {
        cy.loginWithPermissions({ permissions: 'role.view' });
        cy.visit('/roles/show/1');

        cy.get('[data-cy=page-header-title]').should('contain', 'Admin');
    });

    context('Testing system permissions', () => {
        it('can see the view button when user has permissions', () => {
            cy.loginWithPermissions({ permissions: 'role.view' });
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=view]');
            });
        });

        it('cannot see the view button when user is missing permissions', () => {
            cy.loginWithPermissions({ permissions: 'role.create' });
            cy.visit('/roles');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=view]').should('not.exist');
            });
        });
    });
});
