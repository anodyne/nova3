// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add("login", (email, password) => { ... })
//

import 'cypress-file-upload';

Cypress.Commands.add('auth', () => cy.request(`/__testing__/auth`).its('body'));

Cypress.Commands.add('create', (model, attributes = {}) => cy.request(`/__testing__/create/${model}`, attributes).its('body'));

Cypress.Commands.add('login', (attributes = {}) => cy.request('/__testing__/login', attributes));

Cypress.Commands.add('loginWithPermissions', (attributes = {}) => cy.request('/__testing__/login-with-permissions', attributes));

Cypress.Commands.add('logout', () => cy.request('/__testing__/logout'));

//
// -- This is a child command --
// Cypress.Commands.add("drag", { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add("dismiss", { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite("visit", (originalFn, url, options) => { ... })
