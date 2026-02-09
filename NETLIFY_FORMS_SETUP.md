# Netlify Forms Setup Guide

## ✅ Form Configuration Complete

Your service request form has been configured for Netlify Forms with:
- ✅ Proper form attributes (`name="service-request"`, `data-netlify="true"`)
- ✅ Honeypot spam protection (`netlify-honeypot="bot-field"`)
- ✅ Success page redirect (`/service/success/`)
- ✅ File upload support

---

## 🚀 Deployment & Setup Steps

### 1. Deploy to Netlify

First, deploy your site to Netlify (not just local dev):

```bash
# Option A: Deploy to production
npm run deploy

# Option B: Deploy to draft URL for testing
netlify deploy
```

**IMPORTANT**: Netlify Forms only work on deployed sites, NOT in local dev (`netlify dev`). You must deploy to test.

---

### 2. Configure Form Notifications in Netlify Dashboard

After deploying, set up email notifications so you **never miss a submission**:

1. Go to your site in Netlify Dashboard
2. Navigate to **Site Settings > Forms > Form notifications**
3. Click **Add notification**
4. Select **Email notification**
5. Add your email(s) where you want to receive form submissions
6. Save the notification

**Recommended**: Add multiple email addresses (e.g., service@standarddoors.com and a backup)

---

### 3. Test the Form (Production Testing)

After deployment:

1. Visit your deployed site: `https://forms.standarddoors.com/service/`
2. Fill out and submit a test form with **real test data**
3. Verify:
   - ✅ Redirects to `/service/success/` page
   - ✅ Check Netlify Dashboard > Forms > "service-request" - submission should appear within 1-2 minutes
   - ✅ Verify email notification was received
   - ✅ Test file uploads (upload actual images/PDFs)

---

## 📊 Monitoring Form Submissions

### View Submissions in Netlify Dashboard

1. Log into Netlify
2. Select your site
3. Go to **Forms** tab
4. Click on **service-request** form
5. View all submissions with timestamps

### Download Submissions

- You can export all form data as CSV from the Netlify Dashboard
- Submissions include all fields + uploaded files

---

## 🔒 Security & Spam Protection

### Enabled Protections:

1. **Honeypot Field**: Hidden field that bots will fill out (humans won't see it)
2. **Netlify's Built-in Spam Detection**: Automatically filters obvious spam

### Optional Additional Protection:

If you get spam, you can add reCAPTCHA:

```html
<!-- Add to your form tag -->
<form name="service-request" method="POST" data-netlify="true" 
      netlify-honeypot="bot-field" 
      data-netlify-recaptcha="true">
  
  <!-- Add before submit button -->
  <div data-netlify-recaptcha="true"></div>
</form>
```

---

## 📧 Email Notification Setup (Critical!)

### Recommended Configuration:

1. **Primary Email**: service@standarddoors.com
2. **Backup Email**: Add a personal email or team email
3. **Notification Format**: Include form data in email

### Custom Email Notifications:

You can also use:
- Slack notifications
- Webhook notifications (send to your own system)
- Zapier integration (forward to CRM, database, etc.)

---

## 🧪 Testing Checklist

Before going live, test:

- [ ] Form submits successfully
- [ ] Redirects to success page
- [ ] Submission appears in Netlify Dashboard within 2 minutes
- [ ] Email notification received
- [ ] All form fields captured correctly
- [ ] File uploads work (test with images and PDFs)
- [ ] Test from both Canada and USA addresses
- [ ] Test with all required fields filled
- [ ] Test validation (try submitting empty form)
- [ ] Test on mobile device
- [ ] Test spam protection (don't fill honeypot manually)

---

## 📁 File Upload Limits

### Current Limits:
- **Max file size**: 7 MB per file (as configured)
- **Max files**: 10 files per submission
- **Allowed types**: jpg, jpeg, gif, png, pdf, tiff

### Netlify Limits:
- Netlify stores uploaded files automatically
- Files are accessible via Netlify Dashboard
- Free tier: 100 submissions/month, 10MB storage per submission
- Paid tier: Higher limits available

---

## 🐛 Troubleshooting

### Form not submitting?

1. **Check Netlify Dashboard > Forms**: Does "service-request" form appear?
   - If NO: Make sure you deployed after adding form attributes
   - Netlify detects forms during build/deploy

2. **Clear form detection**: If form doesn't appear
   ```bash
   # Make a small change to the form and redeploy
   # Or trigger a new deploy in Netlify Dashboard
   ```

3. **Check browser console**: Look for JavaScript errors

4. **Test basic form first**: Remove all JavaScript and test bare form submission

### Not receiving emails?

1. Check spam/junk folder
2. Verify email address in Netlify Dashboard > Forms > Form notifications
3. Check Netlify Dashboard > Forms > Submissions - if submissions appear there but no email, it's a notification config issue
4. Try adding a different email address

### File uploads not working?

1. Check file size < 7MB
2. Check file type is allowed
3. Try with single file first
4. Check Netlify build logs for errors

---

## 🔄 Backup Strategy

### Never Lose a Submission:

1. **Enable email notifications** (primary backup)
2. **Regularly export CSV** from Netlify Dashboard
3. **Optional**: Set up Zapier automation to send submissions to Google Sheets or your database
4. **Optional**: Use webhooks to POST submissions to your own server/database

### Webhook Setup (Advanced):

```bash
# In Netlify Dashboard: Site Settings > Forms > Form notifications
# Add "Outgoing webhook"
# Point to your server endpoint: https://your-server.com/webhook
```

---

## 💰 Netlify Forms Pricing

### Free Tier:
- 100 submissions/month
- Good for low-volume forms

### If you exceed free tier:
- Upgrade to Pro: $19/month for 1,000 submissions
- Or use alternative form backend (FormSpree, Basin, etc.)

---

## 📱 Form Data Structure

Your form will capture:

```
- today (date)
- production_number (text)
- proof_of_purchase (file)
- dealer_name, dealer_email, inspected_by
- homeowner_first_name, homeowner_last_name
- country, address fields (CA/US)
- phone_1, phone_2 with types
- notify_homeowner (yes/no)
- homeowner_email (conditional)
- mini_blinds_warped_slabs (yes/no)
- issue_description, additional_comments
- issue_photos (multiple files)
```

---

## ✅ You're All Set!

Your form is now configured to be bulletproof:
1. ✅ Deploy to Netlify
2. ✅ Set up email notifications
3. ✅ Test thoroughly
4. ✅ Monitor submissions

**Remember**: Always check Netlify Dashboard after deployment to confirm the form is detected and working!
