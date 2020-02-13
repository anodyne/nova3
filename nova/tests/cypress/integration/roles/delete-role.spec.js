describe('Deleting a role', () => {
    it('shows the delete button to users who have delete permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.delete' });
        cy.visit('/roles');

        cy.get('main .dropdown-trigger').first().click();
        cy.get('.dropdown-link-danger').contains('Delete');
    });

    it('does not show the delete button to users who do not have delete permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });
        cy.visit('/roles');

        cy.get('main .dropdown-trigger').first().click();
        cy.get('.dropdown-link-danger').should('not.exist');
    });
});
