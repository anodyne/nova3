describe('List all users', () => {
    beforeEach(() => {
        cy.loginWithPermissions({ permissions: 'user.create' });
        cy.visit('/users');
    });

    it('can navigate to the users index page', () => {
        cy.url().should('contain', '/users');
        cy.get('[data-cy=page-header-title]').should('contain', 'Users');
    });

    context('Filtering the users list', () => {
        it('can filter users by name from the search field', () => {
            cy.create('Nova-Users-Models-User').then((user) => {
                cy.get('[data-cy=search-field]').type(user.name);
                cy.get('[data-cy=panel]').first().within(() => {
                    cy.contains(user.name);
                });
            });
        });

        it('can filter users by email from the search field', () => {
            cy.create('Nova-Users-Models-User').then((user) => {
                cy.get('[data-cy=search-field]').type(user.email);
                cy.get('[data-cy=panel]').first().within(() => {
                    cy.contains(user.name);
                });
            });
        });

        it('can clear the users search filter', () => {
            cy.create('Nova-Users-Models-User', { name: 'AAA' }).then((user) => {
                cy.get('[data-cy=search-field]').type('foo');
                cy.get('[data-cy=search-clear]').click();
                cy.get('[data-cy=panel]').first().within(() => {
                    cy.contains(user.name);
                });
            });
        });

        it('shows a warning message when no users were found', () => {
            cy.get('[data-cy=search-field]').type('baz');
            cy.contains('No users found');
        });
    });
});
