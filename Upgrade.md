# Upgrade instruction

This document describes the changes needed when upgrading because of a BC break.

## 1.2.x to 1.3.x

### Configuration
The configuration for the logging machanism has changed.

Before:
```yml
prezent_pushwoosh:
  log_requests: true 
```

After:
```yml
prezent_pushwoosh:
  logging: ~ 
```