describe('Reset Password', () => {
    it('can show the password reset page', () => {
        cy.visit('/password/reset/abc123');
    });

    it('displays an error message when the reset token is invalid', () => {
        cy.create('Nova-Users-Models-User').then((user) => {
            cy.visit('/password/reset/abc123');

            cy.get('#email').type(user.email);
            cy.get('#password').type('password');
            cy.get('#password-confirm').type('password');
            cy.get('button').contains('Reset Password').click();

            cy.contains('This password reset token is invalid.');
        });
    });

    it('displays an error message when the email address is invalid', () => {
        cy.visit('/password/reset/abc123');

        cy.get('#email').type('foo@example.com');
        cy.get('#password').type('password');
        cy.get('#password-confirm').type('password');
        cy.get('button').contains('Reset Password').click();

        cy.contains(`We can't find a user with that e-mail address.`);
    });

    it('displays an error message when the passwords do not match', () => {
        cy.create('Nova-Users-Models-User').then((user) => {
            cy.visit('/password/reset/abc123');

            cy.get('#email').type(user.email);
            cy.get('#password').type('password');
            cy.get('#password-confirm').type('password');
            cy.get('button').contains('Reset Password').click();

            cy.contains('This password reset token is invalid.');
        });
    });
});
