# Access Control in Nova 3

## Roles

## Tasks

Now that you understand what a _role_ is in Nova 3, now let's talk about what makes up a role.

In previous versions of Nova and SMS, access control was more rigid; you either had access or you didn't. The lack of granular control meant that game masters were stuck with the authorization model that we had decided on. In most cases, that worked just fine, but there are always times where game masters wanted more control over who was able to do what. Enter tasks.

In Nova 3, every role is defined by a series of tasks, or things users can and can't do. Tasks are incredibly flexible, so it's really easy for third-party developers to create their own tasks for their custom work and have game masters add those tasks to any access role they want.

So what makes up a task? Let's take a closer look.

### Components

A component is simply a piece of Nova functionality users can interact with. For our purposes, a component is almost always defined in shorthand to make it easier to store in the database. For example, the Writing Control Panel and all of its pages are defined under the _writing_ component. Nova comes with pre-defined components, but for anyone developing new functionality, you can create your own components by simply typing what you want to call it into the task's component field when creating or editing a task.

<p class="alert alert-info">Just because you create a new component doesn't mean the Nova core understands what it means. If you want Nova to use your new components, you'll need to extend the Nova core and make those changes manually.</p>

### Actions

Now that we have all these components, we need to be able to tell Nova about the different actions that can be taken on those components. It varies from piece-to-piece, but there are four possible actions that can be taken with each component: create, read, update and delete. Because of the granular control levels allow (talked about below), it's possible to have the same action defined several times for a component.

### Levels

We now have a series of components and their corresponding actions, but if we need to dive deeper, we can assign each action a level and then create as many action/level combinations as we need. Levels are simply a numerical value that helps break down authorization within an action. For example, Nova's posting component has several update levels to control who can update what. Someone with a level 1 task can update their own posts, but someone with a level 2 task can update all posts.

<p class="alert alert-info">You can't simply create a level 3 posting update task and expect Nova to understand what that means. In most cases, levels are hard-coded into the Nova core. If you want to create a new level that defines more granular control, you'll also have to extend any controllers or view that check for those levels.</p>

## Sentry and Citadel