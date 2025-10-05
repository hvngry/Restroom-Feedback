# For setting up app key
```bash
    php artisan key:generate
```

# Resetting Kiosk initialization
## 1. Right click, inspect page element
## 2. On console, type in the following one-at-a-time:
```bash
    localStorage.removeItem("kioskInitialized");
    localStorage.removeItem("kioskNumber");
    localStorage.removeItem("attendeeName");
```
## 3. Refresh page