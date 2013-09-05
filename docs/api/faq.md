# API FAQ

__I want to modify part of the API, how do I do that?__

You can't.

We don't provide any ability or instruction on how to extend or override the API. This was done by design. The Nova API needs to be consistent across every implementation, so allowing any developer to change it would provide unreliable results for any sites or services using the API. To that end, Anodyne strictly controls the API.

If you feel the API is missing something or could benefit from additional information or functionality, please let us know and we'll consider your suggestion.

__Does the Nova API have a token-based authentication system?__

Not yet. Cartalyst (the company that built the package at the heart of the API) is working on some updates that will allow for token-based authentication.

__Does the Nova API have rate limiting?__

Not yet. Cartalyst (the company that built the package at the heart of the API) is working on some updates that will allow rate limiting to prevent servers from getting overrun with requests from a single source.