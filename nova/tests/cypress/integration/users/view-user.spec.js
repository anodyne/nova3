describe('Viewing a user', () => {
    it('can navigate to the view user page', () => {
        cy.loginWithPermissions({ permissions: 'user.view' });
        cy.visit('/users/show/1');

        cy.get('[data-cy=page-header-title]').should('contain', 'admin');
    });

    context('Testing system permissions', () => {
        it('can see the view button when user has permissions', () => {
            cy.loginWithPermissions({ permissions: 'user.view' });
            cy.visit('/users');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=view]');
            });
        });

        it('cannot see the view button when user is missing permissions', () => {
            cy.loginWithPermissions({ permissions: 'user.create' });
            cy.visit('/users');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=view]').should('not.exist');
            });
        });
    });
});
