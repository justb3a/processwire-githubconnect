# ProcessWire GithubConnect

ProcessWire module to connect a Github OAuth application.

## Generate Access Token

### Register a new OAuth application

You have to create an OAuth application to get appId and appSecret. Those keys are required.  
Go to [Github](https://github.com/settings/applications/new) and add a new OAuth application.  
Therefore you've to fill in a **redirect uri**, copy it from module settings.
Congrats! Now you can copy your unique Client ID and Client Secret

### Fill in module settings

Fill in the following fields:

- organization
- Github Client ID
- Github Client Secret

Now save module settings.  
Click the **Authorize!** link to generate code and access token.  
Now the field `Github Access Token` should be filled.

## Use predefined autofill functionality

Create two templates:

- **A** to get the content of the readme
- **B** to get the content of a file inside a repository

Create the following fields:

| ident          | Type     | assign to template | description                                                                    |
|----------------|----------|--------------------|--------------------------------------------------------------------------------|
| fieldSelect    | Option   | A                  | Field which should be filled with Github repositories.                         |
| fieldSubSelect | Option   | B                  | Field which should be filled with files of a Github repository.                |
| fieldPlain     | Text     | A + B              | Field which should store the selected Github repository.                       |
| fieldTeaser    | Textarea | A                  | Field which should contain the imported `description` content (a.k.a. teaser). |
| fieldBody      | Textarea | A + B              | Field which should contain the imported file content.                          |

Add the fields to the appropriate template(s).
Assign the created fields in module settings.

## Endpoints

**Usage Example**

```php
$github = $modules->get('GithubConnect');
$github->setRepository('owner/repository');
$result = $github->getRepositoryInformations();
```

### Set the Repository

You can set a repository initially. So you don't have to pass it every time.

`$github->setRepository('owner/repository');`

- params
  - name of repository, scheme: `:owner/:repo` (string)

### Get Repository Informations

Get informations about a repository.

`$github->getRepositoryInformations($repo);`

- see [Github Api](https://developer.github.com/v3/repos/#get) (to get the complete documentation and an example response)
- params
  - **optional** name of repository, scheme: `:owner/:repo` (string)
- return array

### Get the readme

Get informations about the README file.

`$github->getReadme($repo);`

- see [Github Api](https://developer.github.com/v3/repos/contents/#get-the-readme) (to get the complete documentation and an example response) 
- params
  - **optional** name of repository, scheme: `:owner/:repo` (string)
- return array

### Get the content

Get base64 decoded content of a file.

`$github->getContent($data);`

- params
  - result data for example from `$github->getReadme($repo);` (array)
- return string

### Get the readme content

Get base64 decoded content of a the README.

`$github->getReadmeContent($repo);`

- params
  - **optional** name of repository, scheme: `:owner/:repo` (string)
- return string

### Get certain file

Get informations about a certain file.

`$github->getFile($filename, $repo);`

- see [Github Api](https://developer.github.com/v3/repos/contents/#get-contents) (to get the complete documentation and an example response) 
- params
  - filename
  - **optional** name of repository, scheme: `:owner/:repo` (string)
- return array

### Get content of certain file

Get base64 decoded content of a certain file.

`$github->getContentOfAFile($filename, $repo);`

- see [Github Api](https://developer.github.com/v3/repos/contents/#get-contents) (to get the complete documentation and an example response) 
- params
  - filename
  - **optional** name of repository, scheme: `:owner/:repo` (string)
- return string

### List repositories for the specified org

List all repositories for an specified organization.

`$github->listRepositoriesByOrg($org);`

- see [Github Api](https://developer.github.com/v3/repos/#list-organization-repositories) (to get the complete documentation and an example response) 
- params
  - **optional** name of an organization (defaults to entry from module settings)
- return array

### Get a Tree

Get a tree of a github repository by a sha.

A sha, or "hash", is an individual change to a file or a directory.
Every time you save a file with git, it creates a unique ID (a.k.a. the "SHA" or "hash")
that allows you to keep record of what changes were made when and by who.
Instead of a sha you can also use the name of a branch.

`$github->getTree($sha, $recursive, $repo);`

- see [Github Api](https://developer.github.com/v3/git/trees/#get-a-tree) (to get the complete documentation and an example response) 
- params
  - **optional** sha defaults to branch `master`
  - **optional** recursive defaults to `true`
  - **optional** name of repository, scheme: `:owner/:repo` (string)
- return array
