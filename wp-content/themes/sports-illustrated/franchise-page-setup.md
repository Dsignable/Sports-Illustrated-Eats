# Franchise Page Setup Instructions

This document provides instructions on how to set up the Franchise page for the Sports Illustrated theme.

## Step 1: Create a New Page

1. Go to WordPress Admin > Pages > Add New
2. Set the title to "Franchise Opportunities" or your preferred title
3. From the Page Attributes section, select "Franchise Page" as the template
4. Publish the page

## Step 2: Create a Contact Form 7 Form

1. Go to WordPress Admin > Contact > Add New
2. Set the title to "Franchise Application Form"
3. Copy and paste the form template from `franchise-form-template.txt` into the form editor
4. Configure the email settings:
   - Set the "To" field to: admin@sportsillustratedeats.com
   - Set a descriptive subject line: "New Franchise Application from [your-name]"
   - Make sure all form fields are included in the email body
5. Save the form and note the form ID (shown in the shortcode, e.g., `[contact-form-7 id="123"]`)

## Step 3: Configure the Customizer Settings

1. Go to WordPress Admin > Appearance > Customize
2. Navigate to "Franchise Page Settings"
3. Configure the following settings:
   - Page Title: Set your preferred title (default: "FRANCHISE OPPORTUNITIES")
   - Page Description: Set your preferred description
   - Franchise Image: Upload an image to display on the franchise page
   - Contact Form 7 ID: Enter the ID of the form you created in Step 2
4. Navigate to "Page Background Images"
5. Find the "Franchise Page Background" setting and upload a background image
6. Adjust the opacity as needed
7. Save your changes

## Step 4: Add to Navigation (Optional)

If you want to add the Franchise page to your site's navigation:

1. Go to WordPress Admin > Appearance > Menus
2. Select the menu where you want to add the Franchise page
3. Find the Franchise page in the Pages section and add it to the menu
4. Save the menu

## Troubleshooting

- If the form doesn't appear, verify that Contact Form 7 is active and the form ID is correct
- If the background image doesn't appear, check that it's properly uploaded in the Customizer
- For any CSS issues, you may need to adjust the styles in the theme's CSS files 