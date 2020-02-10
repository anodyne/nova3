describe('Email Password Reset', () => {
    it('can show the email password reset link page', () => {
        cy.visit('/password/reset');
    });

    it('displays an error message when a wrong email address is entered', () => {
        cy.visit('/password/reset');

        cy.get('#email').type('foo@example.com');
        cy.get('button').contains('Send Reset Link').click();

        cy.contains(`We can't find a user with that e-mail address.`);
    });

    it('shows a success message when the reset link is emailed', () => {
        cy.create('Nova-Users-Models-User').then((user) => {
            cy.visit('/password/reset');

            cy.get('#email').type(user.email);
            cy.get('button').contains('Send Reset Link').click();

            cy.contains('We have e-mailed your password reset link!');
        });
    });
});
