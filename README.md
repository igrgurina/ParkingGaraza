upute
=====================

PRIČEKAJ MALO; radim izmjene!

Dalje možete raditi sa tim grafičkim programom (u daljnjem tekstu, program) ili u git shellu (u daljnjem tekstu, konzola).
Za početak, otvorite repozitorij u programu, i gore desno vidite opcije, između ostalog i Open in explorer i Open in GitShell.
Možete kliknuti na oba dvoje, to što vam se otvori u exploreru, tu mjenjate fileove, kreirate projekte u svom IDEu iz tih fileova itd. Sve što promijenite tu će biti lokalno.

Kada ste dovoljno toga promijenili (po vašem mišljenju, moja filozofija je svaki novi feature/metoda/klasa nakon inicijalne verzije treba ići gore), onda se prebacite na konzolu.

Tu vam je program već dosta toga postavio sam od sebe pri pokretanju konzole.
Sada trebate napraviti sljedeće:
https://help.github.com/articles/configuring-a-remote-for-a-fork/
i onda redovito raditi ovo: https://help.github.com/articles/syncing-a-fork/

Zezam se :P
Sve to možete izbjeći ako koristite program, gdje jednostavan klik na Sync button sve synca :)

Naredbe koje vam trebaju su:

- git status 

    pogledajte status repozitorija
- git pull

    pullajte sve moguće promjene (pošto ćete vi raditi na vašem repu, onda njih neće biti)
- git add -A
    
- git commit -m "neka poruka koja objašnjava feature"
- git push

    pushajte vaše lokalne promjene na github repo, ukoliko ne uspijete, vjerovatno morate pullati prvo

I ako ste jako znatiželji
- git log 

    vam izlista sve promjene :)
