describe('Manage Roles', () => {
    it('shows all the roles', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.contains('System Admin');
    });

    it('can filter roles from the search field', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.get(`input[name='search']`).type('admin');
        cy.contains('Basic User').should('not.exist');
    });

    it('can clear the search filter', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.get(`input[name='search']`).type('admin');
        cy.get('button#clear-search').click();

        cy.contains('Basic User');
    });

    it('shows the add button to users who have permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.get(`.button`).contains('Add Role');
    });

    it('does not show the add button to users who do not have permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.update' });

        cy.visit('/roles');
        cy.get(`.button`).contains('Add Role').should('not.exist');
    });
});
