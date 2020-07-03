# Convention Github

## Commit

- Only one feature per commit
- Use english
- Message should be informative, clear and simple
- Commit message
  - Try not to exceed 50 characters
  - Format: `[emoji][location][message][#bug tracker]`
    - **emoji:** The type of modification (new feature, documentation, refactoring, performance improvement, ...)
    - Use the classification from [Gitmoji](https://gitmoji.carloscuesta.me/)
    - Example: `:sparkles:` if the commit add a new feature ✨
      - **location:** Where is the concerned element
        - Use `>` to seperate parts
        - Can be empty if the update doesn't concern a specific element
        - example: `Contact > Form > Error message >`
      - **message** The modification
        - Begin with a capital letter
        - Use imperative mood
        - Begin with a verb like `Add`, `Update`, `Remove`, `Reformat`, `Move`
          - No trailing punctuation
          - Example: `Add hover animation`
      - **bug tracker** Potential bug tracking ID
        - Example: `#1337`
- Commit body
  - Used only if commit message isn't enough
  - Seperate with an empty line
- Avoid commiting unfinished work or specify it in the message using :construction: 🚧
- First commit must be *:tada: Init* 🎉

Source: https://github.com/immersive-garden/guidelines/tree/master/git#commit