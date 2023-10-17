import { extend, override } from 'flarum/common/extend';
import app from 'flarum/forum/app';
import HeaderSecondary from 'flarum/forum/components/HeaderSecondary';
import SettingsPage from 'flarum/forum/components/SettingsPage';
import LogInModal from 'flarum/forum/components/LogInModal';
import { NestedStringArray } from '@askvortsov/rich-icu-message-formatter';



/**
 * Returns login and signup props
 */
function getItems(): Record<string, { url: string; itemName: string; removeItem: boolean; text: string | NestedStringArray }> {
  let baseUrl = "https://account.africoders.com";
  if (location.href.indexOf(".test") !== -1) {
     baseUrl = "https://account.africoders.test";
  }

  return {
    login: {
      url: baseUrl+'/?action=login&continue='+escape(location.href),
      itemName: 'logIn',
      removeItem: false,
      text: app.translator.trans('core.forum.header.log_in_link'),
    },
    signup: {
      url: baseUrl+'/?action=signup&continue='+escape(location.href),
      itemName: 'signUp',
      removeItem: false,
      text: app.translator.trans('core.forum.header.sign_up_link'),
    },
  };
}

app.initializers.add('africoders-laravel-sso', () => {
  override(LogInModal.prototype, 'oncreate', () => {
      //console.log("Login modal shown");
      const items = getItems();
      window.location.href = items.login.url;
      throw new Error('Stop execution');
  });

  extend(HeaderSecondary.prototype, 'items', (buttons) => {
        //console.log("Secondary button shown");

        
      const items = getItems();
      for (const [, props] of Object.entries(items)) {
        if (props.url) {
          if (props.removeItem) {
            buttons.remove(props.itemName);
          } else {
            // Remove login button
            if (!buttons.has(props.itemName)) {
              return;
            }
            buttons.setContent(
              props.itemName,
              <a href={props.url} className="Button Button--link">
                {props.text}
              </a>
            );
          }
        }
      }

  });

  
  extend(SettingsPage.prototype, 'accountItems', (items) => {
    //console.log(items);
    let baseUrl = "https://account.africoders.com";
    if (location.href.indexOf(".test") !== -1) {
       baseUrl = "https://account.africoders.test";
    }

    let changeDisplayName = baseUrl + '/account#information';

    // Remove change email and password buttons
    items.remove('changeEmail');
    items.remove('changePassword');
    //items.remove('changeNickname');

    items.add(
      'manageAccount',
      <a class="Button" href={baseUrl} target={''}>
        {app.translator.trans('africoders-laravel-sso.forum.manage_account_btn')}
      </a>
    );

    items.add(
      'changeNickname',
      <a class="Button" href={changeDisplayName} target={''}>
        {app.translator.trans('africoders-laravel-sso.forum.change_nickname_btn')}
      </a>
    );

    //console.log(items);
  });


});
