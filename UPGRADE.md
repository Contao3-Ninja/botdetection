# BotDetection API changes

## Version 3.x to 4.0.0

### ModuleBotDetection class

The follow methods are deprecated and will be removed in a future version

* **BD_CheckBotAllTests**
  * Use the `ModuleBotDetection` method `checkBotAllTests`
* **BD_CheckBotAgent**
  * Use `CheckBotAgentSimple::checkAgent` instead or the `ModuleBotDetection`
    method `checkBotAllTests`
* **BD_CheckBotAgentAdvanced**
  * Use `CheckBotAgentExtended::checkAgent` instead or the `ModuleBotDetection`
    method `checkBotAllTests`
  * The return value is now always a boolean value, not the name of the bot.
  * For the bot name, if the agent a bot, use `CheckBotAgentExtended::checkAgentName`
    instead
* **BD_CheckBotIP**
  * use `CheckBotIp::checkIP` instead
* **BD_CheckBotReferrer**
  * use `CheckBotReferrer::checkReferrer` instead or the `ModuleBotDetection`
    method `checkBotAllTests`
