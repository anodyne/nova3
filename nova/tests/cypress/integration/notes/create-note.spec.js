describe('Creating a note', () => {
    beforeEach(() => {
        cy.login();
    });

    it('can navigate to create note page from notes index page', () => {
        cy.visit('/notes');

        cy.get('main').within(() => {
            cy.get('[data-cy=create]').click();
        });

        cy.url().should('match', /notes\/create/);
    });

    it('can create a note', () => {
        cy.visit('/notes/create');

        cy.get('[data-cy=title]').type('Title');
        cy.get('[data-cy=content]').type('This is my content');
        cy.get('[data-cy=form]').submit();

        cy.url().should('match', /notes/);
        cy.contains('Title');
    });

    context('Adding attributes', () => {
        beforeEach(() => {
            cy.visit('/notes/create');
        });

        it('requires a title to create a note', () => {
            cy.get('[data-cy=content]').type('foo');
            cy.get('[data-cy=form]').submit();

            cy.contains('The title field is required');
        });
    });
});
