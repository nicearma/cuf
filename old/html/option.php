<script type="text/template" id="cuf_option" >

<p>For any other information about how work this plugin you can go to <a href="http://www.nicearma.com/cleanup-upload-folder/" >Nicearma CUF page</a>
<tbody>
<tr>
    <td scope="row"><p><?php _e('Find if exist in attachement','cuf') ?></p>
    <p><small><?php _e('If you upload files from ftp direct to your wordpress site, this file will not be in the database of attachement','cuf') ?></small></p></td>
    <td><input disabled class="cuf_check" data-dnui="attachement" type="checkbox" name="attachement" <% if(mCUFOption.get('attachement')){ %> checked <% } %>"> </td>
</tr>
<tr>
    <td scope="row"><p><?php _e('Search if is used in one post or page','cuf') ?></p>
    <p><small><?php _e('If you upload files from ftp to your wordpress site, this file will not be in the database, so use this option','cuf') ?></small></p></td>
    <td><input class="cuf_check" data-cuf="use" type="checkbox" name="use" <% if(mCUFOption.get('used')){ %> checked <% } %> "> </td>
</tr>
<tr>
    <td scope="row"><p><?php _e('Make Backup','cuf') ?><sup>version 0.2</sup></p>
    <p><small><?php _e('Use this option for make backup of file that you are trying to delete','cuf') ?></small></p></td>
    <td><input disabled class="cuf_check" data-cuf="backup" type="checkbox" name="backup"  <% if( mCUFOption.get('backup')){ %> checked <% } %> "> </td>
</tr>
<tr>
    <td scope="row"><p><?php _e('let me delete if the file is unued','cuf') ?><sup>version 0.3</sup></p>
    <p><small><?php _e('You can delete all file that are unused','cuf') ?></small></p></td>
    <td><input disabled class="cuf_check" data-cuf="used" type="checkbox" name="used" <% if(mCUFOption.get('canDelete')){ %>  checked <% } %> "> </td>
</tr>

<tr>
    <td scope="row"><p><?php _e('Ignore extension with','cuf') ?><sup>version 0.2</sup></p>
    <p><small><?php _e('Put the extension type without . and ; after each one EX: html;htaccess','cuf') ?></small></p></td>
    <td><input disabled class="cuf_check" data-cuf="used" type="text" name="used" value="<%= mCUFOption.get('ignore') %>"> </td>
</tr>
<tr>
    <td scope="row"><p><?php _e('Slice the search in','cuf') ?><sup>version 0.2 or 0.3</sup></p>
    <p><small><?php _e('If you have a lots of files in one folder, you can slice the search, 0 is unlimited','cuf') ?></small></p></td>
    <td><input disabled  class="cuf_cant" data-dnui="slice" type="number" min="0" name="slice" value="<%= mCUFOption.get('slice') %>"> </td>
</tr>

</tbody>
</script>