describe('Deleting a note', () => {
    beforeEach(() => {
        cy.login();
    });

    it('can delete a note', () => {
        const user = cy.auth();

        cy.create('Nova-Notes-Models-Note', { user_id: user.id });

        cy.create('Nova-Notes-Models-Note', { user_id: user.id }).then((note) => {
            cy.visit('/notes');

            cy.get('main').within(() => {
                cy.contains(note.title).parent().within(() => {
                    cy.get('[data-cy=dropdown-trigger]').first().click();
                    cy.get('[data-cy=delete]').click();
                });
            });

            cy.get('[data-cy=modal]');
            cy.get('[data-cy=modal-title]').should('contain', 'Delete Note');
            cy.get('[data-cy=delete-note]').click();

            cy.get('[data-cy=modal]').should('not.exist');

            cy.get('main').within(() => {
                cy.contains(note.title).should('not.exist');
            });
        });
    });
});
