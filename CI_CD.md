# CI/CD Documentation

## GitHub Actions Workflow

This project uses GitHub Actions to automatically run Playwright E2E tests on code changes.

### Workflow: Playwright Tests

**File**: `.github/workflows/playwright.yml`

**Triggers**:
- Push to `main` branch (direct commits)
- Pull requests targeting `main` branch

**What it does**:
1. Checks out the repository code
2. Sets up Node.js 20 with npm caching for faster builds
3. Installs project dependencies (`npm ci`)
4. Installs Playwright browsers with system dependencies
5. Builds the project (`npm run build`)
6. Runs all Playwright E2E tests (`npx playwright test`)
7. Uploads test reports as artifacts (available for 30 days)

**Timeout**: 60 minutes (generous timeout for comprehensive testing)

**Runner**: Ubuntu Latest (standard GitHub-hosted runner)

### Viewing Test Results

#### In Pull Requests
- Test results appear as a status check on PRs
- Click "Details" next to the check to see the full run
- If tests fail, the PR cannot be merged (recommended to enable branch protection)

#### In the Actions Tab
1. Go to your repository on GitHub
2. Click the "Actions" tab
3. Click on any workflow run to see details
4. Download the "playwright-report" artifact to view HTML reports locally

### Viewing HTML Reports Locally

When tests fail, download the artifact:

```bash
# Unzip the downloaded playwright-report.zip
unzip playwright-report.zip -d playwright-report

# Serve the HTML report
npx playwright show-report playwright-report
```

### Best Practices

#### Branch Protection (Recommended)
Enable branch protection for `main`:

1. Go to Settings > Branches
2. Add rule for `main`
3. Enable "Require status checks to pass before merging"
4. Select "Playwright Tests" as required check
5. Enable "Require branches to be up to date before merging"

This ensures no failing code reaches main.

#### Writing New Tests
- Add new test files to `e2e/` directory
- Follow naming convention: `*.spec.js`
- Tests will automatically run in CI

#### Local Testing Before Push
Always run tests locally before pushing:

```bash
# Run all tests
npm test

# Run specific test file
npx playwright test e2e/service-form.spec.js

# Run in headed mode (see browser)
npx playwright test --headed

# Run with UI mode for debugging
npx playwright test --ui
```

### Troubleshooting CI Failures

#### "npm ci" fails
- Check that `package-lock.json` is committed
- Ensure Node.js version matches (20)

#### Browser installation fails
- The workflow uses `--with-deps` to install system dependencies
- Ubuntu runner should have all required dependencies

#### Build fails
- Run `npm run build` locally to reproduce
- Check for missing environment variables (if needed later)

#### Tests fail in CI but pass locally
- Timing differences: CI may be slower
- Check Playwright timeouts in `playwright.config.js`
- Download and review the playwright-report artifact

#### Artifact upload fails
- Usually a permissions issue
- Verify GitHub Actions has write permissions (should be default)

### Monitoring

#### GitHub Status Badge (Optional)
Add to README.md:

```markdown
![Playwright Tests](https://github.com/StandardDoors/forms-microsite/actions/workflows/playwright.yml/badge.svg)
```

This shows current test status at a glance.

### Future Enhancements

Consider adding:
- **Matrix testing**: Test across multiple browsers/OS
- **Deployment**: Auto-deploy to Netlify on passing tests
- **Performance testing**: Lighthouse CI
- **Visual regression**: Percy or Playwright screenshots
- **Notifications**: Slack/email on failures

### Cost & Resources

- **GitHub Actions minutes**: Free for public repos, 2000 min/month for private
- **Current usage**: ~5-10 minutes per run
- **Artifact storage**: Reports kept for 30 days, minimal storage

### Workflow File Reference

```yaml
name: Playwright Tests

on:
  push:
    branches: [main]
  pull_request:
    branches: [main]

jobs:
  test:
    timeout-minutes: 60
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with:
          node-version: '20'
          cache: 'npm'
      - run: npm ci
      - run: npx playwright install --with-deps
      - run: npm run build
      - run: npx playwright test
      - uses: actions/upload-artifact@v4
        if: ${{ !cancelled() }}
        with:
          name: playwright-report
          path: playwright-report/
          retention-days: 30
```

### Related Documentation

- [Playwright CI Docs](https://playwright.dev/docs/ci)
- [GitHub Actions Docs](https://docs.github.com/en/actions)
- [Playwright Best Practices](https://playwright.dev/docs/best-practices)
