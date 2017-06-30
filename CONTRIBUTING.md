# Contributing to Unfinished

You want to get involved? Great! There are plenty of ways you can help out.

Please take a moment to review this document in order to make the contribution
process easy and effective for everyone involved.

Following these guidelines helps to communicate that you respect the time of
the developers managing and developing this open source project. In return,
they should reciprocate that respect in addressing your issue or assessing
patches and features.

## Using the issue tracker

The [issue tracker][unfinished-issue-tracker] is
the preferred channel for changes: spelling mistakes, wording changes, new
content and generally [submitting pull requests](#pull-requests), but please
respect the following restrictions:

* Please **do not** use the issue tracker for personal support requests (use
  [Stack Overflow][stack-overflow]).

* Please **do not** derail or troll issues. Keep the discussion on topic and
  respect the opinions of others.
  

<a name="pull-requests"></a>
## Pull Requests

Pull requests are a great way to add new features to Unfinished. Pretty much any sort of
change is accepted if seen as constructive.

Adhering to the following this process is the best way to get your work
included in the project:

1. [Fork][fork-a-repo] the project, clone your fork,
   and configure the remotes:

   ```bash
   # Clone your fork of the repo into the current directory
   git clone https://github.com/<your-username>/unfinished.git
   # Navigate to the newly cloned directory
   cd unfinished
   # Assign the original repo to a remote called "upstream"
   git remote add upstream https://github.com/phpsrbija/unfinished.git
   ```

2. If you cloned a while ago, get the latest changes from upstream:

   ```bash
   git checkout master
   git pull upstream master
   ```

3. Create a new topic branch (off the main project development branch) to
   contain your change or fix:

   ```bash
   git checkout -b <topic-branch-name>
   ```
   
4. Commit your changes in logical chunks. Use Git's
   [interactive rebase](https://help.github.com/articles/interactive-rebase)
   feature to tidy up your commits before making them public.

5. Push your topic branch up to your fork:

   ```bash
   git push origin <topic-branch-name>
   ```

6. [Open a Pull Request][using-pull-requests]
    with a clear title and description.
      
[fork-a-repo]: http://help.github.com/fork-a-repo/
[interactive-rebase]: https://help.github.com/articles/interactive-rebase
[using-pull-requests]: https://help.github.com/articles/using-pull-requests/
[stack-overflow]: http://stackoverflow.com/questions/tagged/php
[unfinished-issue-tracker]: https://github.com/phpsrbija/unfinished/issues
