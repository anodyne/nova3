describe('Manage Users', () => {
    it('displays all the users on the index page', () => {
        cy.loginWithPermissions({ permissions: 'user.create' });
        cy.visit('/users');

        cy.url().should('contain', '/users');
        cy.get('.page-header').should('contain', 'Users');
    });

    context('Filtering users list', () => {
        it('can filter users by name from the search field', () => {
            cy.loginWithPermissions({ permissions: 'user.create' });
            cy.visit('/users');

            cy.get(`input[name='search']`).type('admin');
            cy.contains('Basic User').should('not.exist');
        });

        it('can filter users by email from the search field', () => {
            cy.loginWithPermissions({ permissions: 'user.create' });
            cy.visit('/users');

            cy.get(`input[name='search']`).type('basic');
            cy.contains('Admin').should('not.exist');
        });

        it('can clear the users search filter', () => {
            cy.loginWithPermissions({ permissions: 'user.create' });
            cy.visit('/users');

            cy.get(`input[name='search']`).type('admin');
            cy.get('button#clear-search').click();
            cy.contains('Basic User');
        });
    });

    context('User permissions for users', () => {
        it('shows the add button to users who have create permissions', () => {
            cy.loginWithPermissions({ permissions: 'user.create' });
            cy.visit('/users');

            cy.get(`.button`).contains('Add User');
        });

        it('does not show the add button to users who do not have create permissions', () => {
            cy.loginWithPermissions({ permissions: 'user.update' });
            cy.visit('/users');

            cy.contains('Add User').should('not.exist');
        });

        it('shows the edit button to users who have edit permissions', () => {
            cy.loginWithPermissions({ permissions: 'user.update' });
            cy.visit('/users');

            cy.get('main .dropdown-trigger').first().click();
            cy.get(`.dropdown-link`).contains('Edit');
        });

        it('does not show the edit button to users who do not have edit permissions', () => {
            cy.loginWithPermissions({ permissions: 'user.create' });
            cy.visit('/users');

            cy.get('main .dropdown-trigger').first().click();
            cy.contains('Edit').should('not.exist');
        });

        it('shows the delete button to users who have delete permissions', () => {
            cy.loginWithPermissions({ permissions: 'user.delete' });
            cy.visit('/users');

            cy.get('main .dropdown-trigger').first().click();
            cy.get('.dropdown-link-danger').contains('Delete');
        });

        it('does not show the delete button to users who do not have delete permissions', () => {
            cy.loginWithPermissions({ permissions: 'user.create' });
            cy.visit('/users');

            cy.get('main .dropdown-trigger').first().click();
            cy.get('.dropdown-link-danger').should('not.exist');
        });
    });
});
