# Standard Doors Forms Microsite

A simple static microsite for Standard Doors form submissions, built to be hosted on Netlify.

## Pages

1. **Home** (`index.html`) - Landing page with links to both forms
2. **Find Your Production Number** (`/findyourproductionnumber/`) - Instructions for locating production numbers
3. **Service Request Form** (`service.html`) - Complete service request form with file uploads

## Features

- Responsive design using Tailwind CSS
- Netlify Forms integration for easy form submission handling
- Dynamic form fields based on country selection (Canada/USA)
- Conditional email notification fields
- File upload support for proof of purchase and issue photos
- Auto-populated today's date field

## Deployment to Netlify

### Option 1: Drag and Drop
1. Zip the entire project folder
2. Go to [Netlify Drop](https://app.netlify.com/drop)
3. Drag and drop the folder or zip file

### Option 2: Git-based Deployment
1. Initialize a git repository: `git init`
2. Add files: `git add .`
3. Commit: `git commit -m "Initial commit"`
4. Push to GitHub/GitLab/Bitbucket
5. Connect the repository in Netlify dashboard
6. Netlify will auto-detect settings from `netlify.toml`

### Option 3: Netlify CLI
```bash
# Install Netlify CLI
npm install -g netlify-cli

# Login to Netlify
netlify login

# Deploy
netlify deploy --prod
```

## Form Submissions

The service request form uses Netlify Forms. After deployment:

1. Netlify will automatically detect the form (via the `netlify` attribute in the form tag)
2. Form submissions will appear in your Netlify dashboard under Forms
3. You can configure email notifications in the Netlify dashboard

## Files Structure

```
.
├── index.html                          # Home page
├── service.html                        # Service request form
├── findyourproductionnumber/
│   └── index.html                      # Production number instructions
├── Standard-Logo-50-years-Colour.png  # Logo
├── netlify.toml                        # Netlify configuration
└── README.md                           # This file
```

## Notes

- All form fields, labels, and content match the original forms at forms.standarddoors.com
- The design uses a clean, modern approach with Tailwind CSS for responsive layout
- JavaScript handles dynamic form sections (country-based address fields, email notifications)
- File uploads are limited to 7MB with specific file type restrictions as per original requirements
