# AutoResponderGPT for WHMCS

[Read this in Vietnamese](/README_vi.md)

## Description

This project is an addon for WHMCS that automatically responds to new tickets using the ChatGPT API. The addon captures the content and subject of the new ticket, sends them to the ChatGPT API to generate a response combined with user-defined prompt information in the addon config, and then replies to the ticket as an admin.

![Demo](https://i.imgur.com/jm8fGpG.png)

## Features

- Automatically responds to new tickets
- Uses OpenAI ChatGPT to generate responses
- Adds a signature to the end of each response to indicate that the response was generated automatically

## Installation

### Requirements

- WHMCS
- PHP 7.4 or higher
- cURL PHP extension

### Installation Steps

1. **Clone repository**:

   ```bash
   git clone https://github.com/h2ndev/AutoResponderTicketGPT-for-WHMCS.git
   cd AutoResponderTicketGPT-for-WHMCS
   ```

2. **Copy the code to your WHMCS directory**:

   Copy the files from the repository to your WHMCS directory, specifically to the `modules/addons/autorespondergpt` directory.

3. **Cấu hình addon**:

   - Log in to WHMCS Admin.
   - Navigate to `Addons` > `Addon Modules`.
   - Find `AutoResponderGPT` and click `Activate`.
   - Click `Configure` and enter OpenAI API Key and admin username.
   ![Demo](https://i.imgur.com/8FISzOz.png)

## Usage (Automatic)

1. When a new ticket is created, the addon will automatically capture the content and subject of the ticket.
2. The addon will send a request to the ChatGPT API to generate a response.
3. The response will be sent back to the ticket with a signature indicating that the response was generated automatically.
