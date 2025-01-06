# Plugin repository CloudStudio

[![Build Status](https://travis-ci.org/cloudstudio/moodle-repository_cloudstudio.svg?branch=master)](https://travis-ci.org/cloudstudio/moodle-repository_cloudstudio)

CloudStudio is a CMS solution for securely publishing and organizing videos. It offers advanced features for storage, control, and delivery of audiovisual content.

You can integrate it with your Moodle to provide your students with a unique and secure experience.

## Requirements

- Moodle 3.9 or higher.
- Mandatory dependency: **[CloudStudio (moodle-mod_cloudstudio)](https://github.com/eadtech-moodle/moodle-mod_cloudstudio)**. Ensure this module is installed and configured before using this plugin.

## Installation

### 1. Download the plugin

Clone the repository or download the compressed files:

```bash
git clone https://github.com/eadtech-moodle/moodle-repository_cloudstudio.git
```

### 2. Copy to the correct directory

- Extract or copy the plugin folder to the following path in your Moodle:

  ```plaintext
  [Moodle_Directory]/repository/cloudstudio
  ```

### 3. Complete the installation

- Access the Moodle administration panel.
- Navigate to **Site Administration > Notifications**.
- Follow the steps provided to complete the installation.

### 4. Enable the media player

After installation, follow these steps to enable the player:

1. Go to **Site Administration** > **Plugins** >  **Repositories** > **Manage repositories**.
2. Activate the **CloudStudio File Repository** option.

## How to Use

1. Once the media player is activated, you can use the CloudStudio player in any Moodle text editor.
2. Add a CloudStudio video, configure the display options, and save the changes.
3. The video will be displayed using the configured player.

## Support

- For issues or suggestions, use the **Issues** section on GitHub.
- Ensure the **moodle-mod_cloudstudio** module is installed and functioning correctly.

## License

This project is licensed under **GPL v3**. Refer to the [LICENSE](LICENSE) file for more details.

**Created by: [EadTech](https://github.com/eadtech-moodle)**  
Making learning more interactive! 🎓
