# Client Texting Service Design Document
**Status**: Completed

## Context
In our client feedback survey, we found that some of our clients didn't remember contacting us. They reached out to many legal aid and information services regarding their problem, and SCAS got lost in the mix. Following up with clients relies on them calling us back with an update. This makes it hard to know what happens after we give someone information on the phone, and therefore limits how helpful we're able to be.

## Goals and Non-Goals
The goal of this project is to implement an automated texting service to follow up with clients, that way they can keep SCAS in mind as a resource as they're going through the small claims process.

The goal is not to automate the entire process by which we assist clients. The goal is also not to build an incredibly sophisticated texting bot for this first iteration. There will instead be a few states that clients can be in, and we'll send messages based on the state.

## Existing Solution
Currently, volunteers answer calls during office hours and return any missed calls we've received at the office phone. Survey administration is done manually, either during dedicated survey call-a-thons or during office hours f a volunteer doesn't have any calls to return.

## Proposed Solution
The proposed solution is a texting service that will streamline contacting clients and integrate with our current callback process.

### Functional Description
1. When a new contact with a client is added to the database of the types **Called, helped by phone** or **Call received, helped by phone**, they will be sent a text asking if they would like us to follow up in one week.
2. Depending on their response, we either follow up (Y) or administer survey (N).
3. In one week, the system will send a text asking if they still need help.
4. Depending on their response, ask the status of their case or administer survey.
  * Ongoing → ask client to call and give us an update.
  * Won/Lost/Settled → administer survey.

### Database Schema Changes
- `dbi4_Contacts`: Add a column `AutoSent, tinyint(1)` to indicate that the text was sent automatically.
- `db_Clients`: Add two columns — `FollowUp, char(1)` and `FollowUpDate, date`

### Architecture
- Use the Twilio library to send text messages.
- Use cron to schedule tasks.
- The send message component will check the database for clients who we need to follow up with (based on the date) and then send the text.
- The receive message component will handle responses. It will send a hardcoded response based on the client's state and their message.

### User Interface
The user interface won't have any significant changes from the current state of the i4. We'll add a note on the update client page to notify volunteers of this new system.

## Timeline
Date | Goal | Finished?
-----|------|:--------:
8/10 | Complete prototype of texting script that can send and reply to texts. | :white_check_mark:
8/12 | Finish design doc. | :white_check_mark:
8/14 | Implement component that is state-aware and sends appropiate response. |
8/20 | Integrate component with database. |
8/23 | End-to-end testing. |
8/25 | Complete UI changes to let volunteers about the system and what to expect. |
