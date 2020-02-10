describe('Login', () => {
    it('shows the login page', () => {
        cy.visit('/login');
    });

    it('displays an error for invalid login credentials', () => {
        cy.visit('/login');

        cy.get('#email').type('foo@example.com');
        cy.get('#password').type('password123');
        cy.get('button').contains('Sign In').click();

        cy.contains('These credentials do not match our records');
    });

    it('does not display a password error', () => {
        cy.create('Nova-Users-Models-User').then((user) => {
            cy.visit('/login');

            cy.get('#email').type(user.email);
            cy.get('#password').type('password');
            cy.get('button').contains('Sign In').click();

            cy.contains('These credentials do not match our records');
        });
    });

    it('can login a user', () => {
        cy.create('Nova-Users-Models-User').then((user) => {
            cy.visit('/login');

            cy.get('#email').type(user.email);
            cy.get('#password').type('secret');
            cy.get('button').contains('Sign In').click();

            cy.contains('Dashboard');
        });
    });
});
