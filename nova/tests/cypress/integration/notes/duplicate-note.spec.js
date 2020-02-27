describe('Duplicating a note', () => {
    it('can duplicate a note', () => {
        cy.visit('/notes');

        cy.get('main').within(() => {
            cy.get('[data-cy=dropdown-trigger]').first().click();
            cy.get('[data-cy=duplicate]').click();

            cy.url().should('match', /notes\/\d*\/edit/);
        });
    });
});
