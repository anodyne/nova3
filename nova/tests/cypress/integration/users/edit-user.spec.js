describe('Editing a user', () => {
    beforeEach(() => {
        cy.loginWithPermissions({ permissions: 'user.update' });
    });

    it('can navigate to edit user page from users index page', () => {
        cy.visit('/users');

        cy.get('main').within(() => {
            cy.get('[data-cy=dropdown-trigger]').first().click();
            cy.get('[data-cy=edit]').click();
        });

        cy.url().should('match', /users\/\d*\/edit/);
    });

    it('can update a user', () => {
        cy.visit('/users/2/edit');

        cy.get('[data-cy=name]').clear().type('AAA');
        cy.get('[data-cy=form]').submit();

        cy.url().should('match', /users/);
        cy.contains('AAA');
    });

    context('Updating attributes', () => {
        beforeEach(() => {
            cy.visit('/users/2/edit');
        });

        it('requires a name to update a user', () => {
            cy.get('[data-cy=name]').clear();
            cy.get('[data-cy=form]').submit();

            cy.contains('The name field is required');
        });

        it('requires an email address to update a user', () => {
            cy.get('[data-cy=email]').clear();
            cy.get('[data-cy=form]').submit();

            cy.contains('The email field is required');
        });

        it('requires a valid email address to update a user', () => {
            cy.get('[data-cy=email]').clear().type('foo');
            cy.get('[data-cy=form]').submit();

            cy.contains('The email must be a valid email address');
        });
    });

    context('Attaching roles', () => {
        beforeEach(() => {
            cy.visit('/users/2/edit');
        });

        it('can search for roles', () => {
            cy.get('[data-cy=tags-search]').first().type('admin');

            cy.get('[data-cy=tags-search-results]');
            cy.contains('Admin');
        });

        it('can select a role to add to the user', () => {
            cy.get('[data-cy=tags-search]').first().type('admin');

            cy.get('[data-cy=tags-search-results]');
            cy.get('[data-cy=tags-search-results-item]').first().click();

            cy.get('[data-cy=tags-search-results]').should('not.exist');
            cy.get('[data-cy=tag-item]').should('contain', 'Admin');
        });

        it('can remove a selected role from the list', () => {
            cy.get('[data-cy=tags-search]').first().type('admin');
            cy.get('[data-cy=tags-search-results-item]').first().click();
            cy.get('[data-cy=remove-tag-item]').first().click();

            cy.get('[data-cy=tag-item]').should('not.contain', 'Admin');
        });

        it('can clear role search results', () => {
            cy.get('[data-cy=tags-search]').first().type('admin');

            cy.get('[data-cy=tags-search-results]');
            cy.get('[data-cy=reset-tags-search]').click();
            cy.get('[data-cy=tags-search-results]').should('not.exist');
        });
    });

    context('Updating avatar', () => {
        beforeEach(() => {
            cy.visit('/users/2/edit');
        });
    });

    context('Testing system permissions', () => {
        it('can see the edit button when user has permissions', () => {
            cy.visit('/users');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=edit]');
            });
        });

        it('cannot see the edit button when user is missing permissions', () => {
            cy.logout();
            cy.loginWithPermissions({ permissions: 'user.create' });
            cy.visit('/users');

            cy.get('main').within(() => {
                cy.get('[data-cy=dropdown-trigger]').first().click();
                cy.get('[data-cy=edit]').should('not.exist');
            });
        });
    });
});
