describe('Email password reset', () => {
    beforeEach(() => {
        cy.visit('/password/reset');
    });

    it('shows the email password reset page', () => {
    });

    it('displays an error when an invalid email is entered', () => {
        cy.get('[data-cy=email]').type('foo@example.com');
        cy.get('[data-cy=submit]').click();

        cy.contains(`We can't find a user with that e-mail address.`);
    });

    it('shows a success message when the reset link is emailed', () => {
        cy.create('Nova-Users-Models-User').then((user) => {
            cy.get('[data-cy=email]').type(user.email);
            cy.get('[data-cy=submit]').click();

            cy.contains('We have e-mailed your password reset link!');
        });
    });
});
