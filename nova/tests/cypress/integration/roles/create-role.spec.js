describe('Create Role', () => {
    it('shows the add button to users who have create permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });
        cy.visit('/roles');

        cy.get('[data-cy=create]');
    });

    it('does not show the add button to users who do not have create permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.update' });
        cy.visit('/roles');

        cy.get('[data-cy=create]').should('not.exist');
    });

    it('shows the create role page', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });
        cy.visit('/roles/create');

        cy.contains('Add Role');
    });

    it('does not show the create role page if the user does not have create permissions', () => {
        cy.login();
        cy.visit('/roles/create', {
            failOnStatusCode: false
        });
        cy.contains('unauthorized');
    });

    it('requires a role name to create a new role', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });
        cy.visit('/roles/create');

        cy.get('#name').type('foo');
        cy.get('.button').contains('Add Role').click();

        cy.contains('The name field is required');
    });

    it('requires a role key to create a new role', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });
        cy.visit('/roles/create');

        cy.get('#display_name').type('Foo');
        cy.get('#name').clear();
        cy.get('.button').contains('Add Role').click();

        cy.contains('The key field is required');
    });
});
