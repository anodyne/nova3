describe('Reset Password', () => {
    const createResetToken = user => cy.request(`/__testing__/create-reset-token/${user.id}`);

    it('shows the password reset page', () => {
        cy.create('Nova-Users-Models-User').then((user) => {
            createResetToken(user).its('body.token').then((token) => {
                cy.visit(`/password/reset/${token}`);
            });
        });
    });

    it('shows a success message when the password is reset', () => {
        cy.create('Nova-Users-Models-User').then((user) => {
            createResetToken(user).its('body.token').then((token) => {
                cy.visit(`/password/reset/${token}`);

                cy.get('[data-cy=email]').type(user.email);
                cy.get('[data-cy=password]').type('password');
                cy.get('[data-cy=password-confirm]').type('password');
                cy.get('[data-cy=submit]').click();

                cy.url().should('include', '/');
            });
        });
    });

    context('Error messages', () => {
        it('displays an error message when the reset token is invalid', () => {
            cy.create('Nova-Users-Models-User').then((user) => {
                cy.visit('/password/reset/abc123');

                cy.get('[data-cy=email]').type(user.email);
                cy.get('[data-cy=password]').type('password');
                cy.get('[data-cy=password-confirm]').type('password');
                cy.get('[data-cy=submit]').click();

                cy.contains('This password reset token is invalid.');
            });
        });

        it('displays an error message when the email address is invalid', () => {
            cy.visit('/password/reset/abc123');

            cy.get('[data-cy=email]').type('foo@example.com');
            cy.get('[data-cy=password]').type('password');
            cy.get('[data-cy=password-confirm]').type('password');
            cy.get('[data-cy=submit]').click();

            cy.contains(`We can't find a user with that e-mail address.`);
        });

        it('displays an error message when the passwords do not match', () => {
            cy.create('Nova-Users-Models-User').then((user) => {
                createResetToken(user).its('body.token').then((token) => {
                    cy.visit(`/password/reset/${token}`);

                    cy.get('[data-cy=email]').type(user.email);
                    cy.get('[data-cy=password]').type('password');
                    cy.get('[data-cy=password-confirm]').type('passwords');
                    cy.get('[data-cy=submit]').click();

                    cy.contains('The password confirmation does not match.');
                });
            });
        });
    });
});
