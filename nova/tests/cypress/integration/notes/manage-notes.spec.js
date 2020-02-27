describe('List all notes', () => {
    it('can navigate to the notes index page', () => {
        cy.visit('/notes');

        cy.url().should('contain', '/notes');
        cy.get('[data-cy=page-header-title]').should('contain', 'Notes');
        cy.get('[data-cy=panel]').first().within(() => {
            cy.contains('Admin');
        });
    });

    context('Filtering the notes list', () => {
        it('can filter notes by title from the search field', () => {
            cy.visit('/notes');

            cy.get('[data-cy=search-field]').type('admin');
            cy.get('[data-cy=panel]').first().within(() => {
                cy.contains('Admin');
                cy.contains('Basic User').should('not.exist');
            });
        });

        it('can filter notes by content from the search field', () => {
            cy.visit('/notes');

            cy.get('[data-cy=search-field]').type('basic');
            cy.get('[data-cy=panel]').first().within(() => {
                cy.contains('Basic User');
                cy.contains('Admin').should('not.exist');
            });
        });

        it('can clear the notes search filter', () => {
            cy.visit('/notes');

            cy.get('[data-cy=search-field]').type('admin');
            cy.get('[data-cy=search-clear]').click();
            cy.get('[data-cy=panel]').first().within(() => {
                cy.contains('Basic User');
                cy.contains('Admin');
            });
        });

        it('shows a warning message when no notes were found', () => {
            cy.get('[data-cy=search-field]').type('baz');
            cy.contains('No notes found');
        });
    });
});
