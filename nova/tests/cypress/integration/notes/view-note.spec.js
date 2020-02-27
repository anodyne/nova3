describe('Viewing a note', () => {
    it('can navigate to the view note page', () => {
        cy.visit('/notes/show/1');

        cy.get('[data-cy=page-header-title]').should('contain', 'Admin');
    });
});
