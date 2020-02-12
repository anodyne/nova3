describe('Manage Roles', () => {
    it('shows all the roles', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.contains('System Admin');
    });

    it('can filter roles by key from the search field', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.get(`input[name='search']`).type('admin');
        cy.contains('Basic User').should('not.exist');
    });

    it('can filter roles by display name from the search field', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.get(`input[name='search']`).type('basic');
        cy.contains('Admin').should('not.exist');
    });

    it('can clear the roles search filter', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.get(`input[name='search']`).type('admin');
        cy.get('button#clear-search').click();

        cy.contains('Basic User');
    });

    it('shows the add button to users who have create permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.get(`.button`).contains('Add Role');
    });

    it('does not show the add button to users who do not have create permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.update' });

        cy.visit('/roles');
        cy.contains('Add Role').should('not.exist');
    });

    it('shows the edit button to users who have edit permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.update' });

        cy.visit('/roles');
        cy.get('main .dropdown-trigger').first().click();
        cy.get(`.dropdown-link`).contains('Edit');
    });

    it('does not show the edit button to users who do not have edit permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.get('main .dropdown-trigger').first().click();
        cy.contains('Edit').should('not.exist');
    });

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

    it('shows the duplicate button to users who have create and update permissions', () => {
        cy.loginWithPermissions({ permissions: ['role.create', 'role.update'] });

        cy.visit('/roles');
        cy.get('main .dropdown-trigger').first().click();
        cy.get('.dropdown-link').contains('Duplicate');
    });

    it('does not show the duplicate button to users who do not have create and update permissions', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });

        cy.visit('/roles');
        cy.get('main .dropdown-trigger').first().click();
        cy.contains('Duplicate').should('not.exist');
    });
});
