describe('Editing a note', () => {
    it('can navigate to edit note page from notes index page', () => {
        cy.visit('/notes');

        cy.get('main').within(() => {
            cy.get('[data-cy=dropdown-trigger]').first().click();
            cy.get('[data-cy=edit]').click();
        });

        cy.url().should('match', /notes\/\d*\/edit/);
    });

    it('can update a note', () => {
        cy.visit('/notes/2/edit');

        cy.get('[data-cy=title]').clear().type('New Title');
        cy.get('[data-cy=form]').submit();

        cy.url().should('match', /notes/);
        cy.contains('New Title');
    });

    context('Updating attributes', () => {
        beforeEach(() => {
            cy.visit('/roles/2/edit');
        });

        it('requires a title to update a note', () => {
            cy.get('[data-cy=title]').clear();
            cy.get('[data-cy=form]').submit();

            cy.contains('The title field is required');
        });
    });
});
