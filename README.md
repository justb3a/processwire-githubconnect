# ProcessWire GithubConnect

ProcessWire module to connect a Github OAuth application.

## Register a new OAuth application

You have to create an OAuth application to get appId and appSecret. Those keys are required.  
Go to [Github](https://github.com/settings/applications/new) and add a new OAuth application.  
Congrats! Now you can copy your unique Client ID and Client Secret

## Fill in module settings

### Part 1

- organization
- Github Client ID
- Github Client Secret

Save module settings.  
Click the **Authorize!** link to generate code and access token.  
Now `Github Access Token` should be filled.

### Part 2

Create the following fields:

- **Type Option**: Field which should be filled with Github repositories.
- **Type Text**: Field which should store the selected Github repository.
- **Type Textarea**: Field which should contain the imported `description` content (a.k.a. teaser).
- **Type Textarea**: Field which should contain the imported `readme`-file content.

Add all fields to the same template.

### Part 3

Assign the created fields in module settings.
