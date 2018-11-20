# customui
Library status + Virion download: [![Poggit-CI](https://poggit.pmmp.io/ci.badge/thebigsmileXD/customui/customui)](https://poggit.pmmp.io/ci/thebigsmileXD/customui/customui)
Example Plugin Status: [![Poggit-CI](https://poggit.pmmp.io/ci.badge/thebigsmileXD/customui/customuitest)](https://poggit.pmmp.io/ci/thebigsmileXD/customui/customuitest)

Library to create custom UI's in MCPE 1.2+
## Lets you:
- Create custom UI's
- Send/close them to/from players
- Handle the data/replies
- Dynamically generate window data
- Include as viron into your plugins to create new UI's

## Main advantages
This virion makes handling response data easy - it already gives the proper result instead of weird and unclear numbers everywhere.

In example:
 - a **ModalForm** only returns `true` when the first button was clicked
 - a **SimpleForm** (only buttons) returns `the text of the clicked button` (so it can easily be used in `switch-case` without worrying about which button has which index in the form)
 - A **CustomForm** and a **ServerForm** returns `the values for each of its elements` in correct order

## Why use this virion instead of a plugin (i.e. FormAPI)?
It is a library instead of a plugin because there is no need to handle form replies via event listeners anymore in pmmp
and it probably saves resources on the server.
You are still able to fully control sent forms, data etc.

## How to use this repo?
NEW! In-depth explanation in the wiki!

Check out the source of the example plugin (customuitest). It is a full example of registering, sending and handling responses via plugins :)

# How do i code with it?
When developing plugins, you want to get [DEVirion](https://github.com/poggit/devirion), and load a virion from source.

Read [the virion support information](https://github.com/poggit/support) and the [customui wiki](https://github.com/thebigsmilexd/customui/wiki) for more in-depth explanations

---
**_`As of: 20. November 2018`_**