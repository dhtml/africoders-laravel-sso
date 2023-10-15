import { extend, override } from 'flarum/common/extend';
import app from 'flarum/forum/app';
import HeaderSecondary from 'flarum/forum/components/HeaderSecondary';
import SettingsPage from 'flarum/forum/components/SettingsPage';
import LogInModal from 'flarum/forum/components/LogInModal';
import { NestedStringArray } from '@askvortsov/rich-icu-message-formatter';


app.initializers.add('maicol07-sso', () => {
  override(LogInModal.prototype, 'oncreate', () => {
    console.log("Login modal");
  });

  extend(HeaderSecondary.prototype, 'items', (buttons) => {
        console.log("Secondary button");
  });

});
