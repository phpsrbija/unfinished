# Doprinos

Ovaj dokument sadrži opšta uputstva za doprinos ovom projektu.

## Pull request-ovi

Poštujte ovu proceduru kako bi vaš rad i predlozi bili usvojeni i prihvaćeni u ovom projektu:

1. [Fork-ujte][fork-a-repo] ovaj project, klonirajt vaš fork i podesite `remote` za vaš repo:

   ```bash
   # Kloniraj repo u trenutni folder
   git clone https://github.com/<tvoj-username>/unfinished.git
   # Uđi u folder kreiranog klona
   cd unfinished
   # Podesi izvorni repo kao remote pod nazivom "upstream"
   git remote add upstream https://github.com/phpsrbija/unfinished
   ```

2. Sinhronizacija sa izvornim repozitorijumom:

   ```bash
   git checkout master
   git pull upstream master
   ```

3. Commit-ujte/push-ujte u logičnim celinama. Preporučujemo da squash-ujte commit-e pomoću
   [interaktivnog rebase-a][interactive-rebase].

4. [Otvorite pull request][using-pull-requests] sa jasnim naslovom i opisom.

[fork-a-repo]: http://help.github.com/fork-a-repo/
[interactive-rebase]: https://help.github.com/articles/interactive-rebase
[using-pull-requests]: https://help.github.com/articles/using-pull-requests/
