describe('List all roles', () => {
    it('can navigate to the roles index page', () => {
        cy.loginWithPermissions({ permissions: 'role.create' });
        cy.visit('/roles');

        cy.url().should('contain', '/roles');
        cy.get('[data-cy=page-header-title]').should('contain', 'Roles');
        cy.get('[data-cy=panel]').first().within(() => {
            cy.contains('Admin');
        });
    });

    context('Filtering the roles list', () => {
        it('can filter roles by key from the search field', () => {
            cy.loginWithPermissions({ permissions: 'role.create' });
            cy.visit('/roles');

            cy.get('[data-cy=search-field]').type('admin');
            cy.get('[data-cy=panel]').first().within(() => {
                cy.contains('Admin');
                cy.contains('Basic User').should('not.exist');
            });
        });

        it('can filter roles by display name from the search field', () => {
            cy.loginWithPermissions({ permissions: 'role.create' });
            cy.visit('/roles');

            cy.get('[data-cy=search-field]').type('basic');
            cy.get('[data-cy=panel]').first().within(() => {
                cy.contains('Basic User');
                cy.contains('Admin').should('not.exist');
            });
        });

        it('can clear the roles search filter', () => {
            cy.loginWithPermissions({ permissions: 'role.create' });
            cy.visit('/roles');

            cy.get('[data-cy=search-field]').type('admin');
            cy.get('[data-cy=search-clear]').click();
            cy.get('[data-cy=panel]').first().within(() => {
                cy.contains('Basic User');
                cy.contains('Admin');
            });
        });

        it('shows a warning message when no roles were found', () => {
            cy.get('[data-cy=search-field]').type('baz');
            cy.contains('No roles found');
        });
    });
});
