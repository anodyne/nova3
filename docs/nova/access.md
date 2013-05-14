# Access Control in Nova 3

What is access control?

In the simplest terms, access control is the rules around what users can do inside of Nova. Access control involves several components which are discussed below.

## Roles

Every user in Nova is assigned an access role which tells the system what they're allowed to do. By default, we lump standard users into the _Active User_ role. If you want to change the access that entire group of users has, you can simply change the role.

## Tasks

Now that you understand what a _role_ is in Nova 3, now let's talk about what makes up a role.

In previous versions of Nova and SMS, access control was more rigid; you either had access or you didn't. The lack of granular control meant that game masters were stuck with the authorization model we had decided on. In most cases, that worked just fine, but there were times where game masters wanted more control over who was able to do what.

Enter tasks.

In Nova 3, every role is defined by a series of tasks, or things users can do. Tasks are incredibly flexible, so it's really easy for third-party developers to create their own tasks for their custom work and have game masters add those tasks to any access role they want.

So what makes up a task? Let's take a closer look.

### Components

A component is simply a piece of Nova functionality users can interact with. For our purposes, a component is almost always defined in shorthand to make it easier to store in the database. For example, the Mission Posting component is defined under the _post_ component. Nova comes with pre-defined components, but for anyone developing new functionality, you can create your own components by simply typing what you want to call it into the task's component field when creating or editing a task.

<p class="alert alert-info">Just because you create a new component doesn't mean the Nova core understands what it means. If you want Nova to use your new components, you'll need to extend the Nova core and make those changes manually.</p>

### Actions

Now that we have all these components, we need to be able to tell Nova about the different actions that can be taken on those components. It varies from component-to-component, but there are four possible actions that can be taken with each component: create, read, update and delete. Because of the granular control levels allow (talked about below), it's possible to have the same action defined several times for a component.

### Levels

We now have a series of components and their corresponding actions, but if we need to dive deeper, we can assign each action a level and then create as many action/level combinations as we need. Levels are simply a numerical value that helps break down authorization within an action. For example, Nova's posting component has several update levels to control who can update what. Someone with a level 1 task can update their own posts, but someone with a level 2 task can update all posts.

<p class="alert alert-info">You can't simply create a level 3 posting update task and expect Nova to understand what that means. In most cases, levels are hard-coded into the Nova core. If you want to create a new level that defines more granular control, you'll also have to extend any controllers or views that check for those levels.</p>

## Role Inheritance

Now you know what access roles are and how they're defined to help you manage the access your users have. With that understand, we'll dive deeper into one of the most important concepts to understand about access roles for anyone who wants to create new roles or edit existing roles: role inheritance.

In previous versions of Nova, we've built a far more rigid structure when it comes to defining access roles. This led to a significant amount of duplication and headaches when managing roles. We wanted to create something that was more flexible and easier to maintain and one of the best ways to do that was to allow for roles to inherit the tasks from other roles.

Let's go over that one more time: any role can inherit the tasks for any other number of roles.

Here's an example to make it a little clearer.

The _System Administrator_ role inherits tasks from the _User_, _Active User_, _Power User_ and _Administrator_ roles. That means that any changes made to any of those roles __also__ impacts the _System Administrator_ role. If you want to add some access to a role, you simply start at the lowest point you want that to apply.

As another example, creating a new announcement requires the _Power User_ role. Let's say, however, you want every _Active User_ to be able to add a new announcement. To do that, you would simply remove the Create Announcement task from the _Power User_ role and add it to the _Active User_ role. Now, everyone who has a role of _Active User_ or higher will be able to add new announcements.

## For Developers

More information about access control is available as part of the Dev Center where we talk about integrating access control into your custom solutions as well as describing Sentry and Citadel, the access control components built in to the Nova core.