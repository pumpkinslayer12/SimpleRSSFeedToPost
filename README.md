# simple-old-plugin

if (has_action(self::AdminMenuHook, [get_called_class(), 'addOptionsPage'])) {
            trigger_error("Valid Class", E_USER_ERROR);
        } else {
            trigger_error("Invalid Class", E_USER_ERROR);
        }
 
