
TYPO3 Extension "extbase_strict"
================================

This extension is a proof of concept for fixing the currently unsolved problem of extbase and the language mode "strict".

Currently records are removed from the result while doing the overlay which is a step too late. Calls like ```$query->execute()->count();``` produce the wrong results.  


Solution
--------------

The extension overrides the method ```Typo3DbQueryParser->addSysLanguageStatement()``` and changes the query for strict mode.

In the long term, the code should be moved to the core, this extension is just a way to make the changes more easily testable!


License
--------------

GPL