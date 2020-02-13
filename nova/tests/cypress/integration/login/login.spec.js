describe('Login', () => {
    beforeEach(() => {
        cy.visit('/login');
    });

    const login = (email, password) => {
        cy.get('[data-cy=email]').type(email);
        cy.get('[data-cy=password]').type(password);
        cy.get('[data-cy=submit]').click();
    };

    it('shows the login page', () => {
    });

    context('Incorrect credentials', () => {
        it('displays an error when invalid email and password are entered', () => {
            login('foo@example.com', 'password123');

            cy.url().should('include', 'login');
            cy.contains('These credentials do not match our records');
        });

        it('displays an error when invalid email is entered', () => {
            login('foo@example.com', 'secret');

            cy.url().should('include', 'login');
            cy.contains('These credentials do not match our records');
        });

        it('displays an error when invalid password is entered', () => {
            cy.create('Nova-Users-Models-User').then((user) => {
                login(user.email, 'password123');

                cy.url().should('include', 'login');
                cy.contains('These credentials do not match our records');
            });
        });

        it('temporarily locks an account after 5 failed login attempts', () => {
            cy.create('Nova-Users-Models-User').then((user) => {
                login(user.email, 'password123');
                cy.get('[data-cy=email]').clear();

                login(user.email, 'password123');
                cy.get('[data-cy=email]').clear();

                login(user.email, 'password123');
                cy.get('[data-cy=email]').clear();

                login(user.email, 'password123');
                cy.get('[data-cy=email]').clear();

                login(user.email, 'password123');
                cy.get('[data-cy=email]').clear();

                login(user.email, 'password123');

                cy.url().should('include', 'login');
                cy.contains('Too many login attempts');
            });
        });
    });

    context('Correct credentials', () => {
        it('redirects to the dashboard on success', () => {
            cy.create('Nova-Users-Models-User').then((user) => {
                login(user.email, 'secret');

                cy.url().should('include', 'dashboard');
                cy.get('.page-header').should('contain', 'Dashboard');
            });
        });
    });
});
