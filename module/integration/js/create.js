$('#repo').change(function()
{
    var repoID = $(this).val();
    var type   = 'Git';
    if(typeof(repoTypes[repoID]) != 'undefined') type = repoTypes[repoID];
    $('.svn-fields').toggleClass('hidden', type != 'Subversion');
    $('#repoType').val(type);
    if(type == 'Subversion')
    {
        $('#svnFolderBox').html("<div class='load-indicator loading'></div>");
        $.getJSON(createLink('repo', 'ajaxGetSVNTags', 'repoID=' + repoID), function(svnTags)
        {
            var tags    = svnTags['tags'];
            var parents = svnTags['parent'];

            html = "<select id='svnFolder' name='svnFolder' class='form-control'>";
            for(tag in parents)
            {
                var info = parents[tag];
                html += "<option value='" + info['path'] + "' data-encodePath='" + info['encodePath'] + "'>" + info['path'] + "</option>";
            }

            for(tag in tags)
            {
                var info = tags[tag];
                html += "<option value='" + info['path'] + "' data-encodePath='" + info['encodePath'] + "'>" + info['path'] + "</option>";
            }
            html += '</select>';
            $('#svnFolderBox').html(html);
            $('#svnFolderBox #svnFolder').chosen();
        })
    }
})

$(document).on('change', '#svnFolder', function()
{
    var repoID      = $('#repo').val();
    var selectedTag = $(this).val();
    var encodePath  = $(this).find("option:selected").attr('data-encodePath');
    $('#svnFolderBox').html("<div class='load-indicator loading'></div>");
    $.getJSON(createLink('repo', 'ajaxGetSVNTags', 'repoID=' + repoID + '&path=' + encodePath), function(svnTags)
    {
        var tags    = svnTags['tags'];
        var parents = svnTags['parent'];

        html = "<select id='svnFolder' name='svnFolder' class='form-control'>";
        for(tag in parents)
        {
            var info = parents[tag];
            html += "<option value='" + info['path'] + "' data-encodePath='" + info['encodePath'] + "'>" + info['path'] + "</option>";
        }

        for(tag in tags)
        {
            var info = tags[tag];
            html += "<option value='" + info['path'] + "' data-encodePath='" + info['encodePath'] + "'>" + info['path'] + "</option>";
        }
        html += '</select>';
        $('#svnFolderBox').html(html);
        $('#svnFolderBox #svnFolder').val(selectedTag).chosen();
    })
})

$('#triggerType').change(function()
{
    var type = $(this).val();
    if(type == 'tag')
    {
        $('.tag-fields').removeClass('hidden');
        $('.comment-fields').addClass('hidden');

        scheduleTypeChanged();
    }
    else if(type == 'commit')
    {
        $('.tag-fields').addClass('hidden');
        $('.comment-fields').removeClass('hidden');
        $('.custom-fields').addClass('hidden');

        scheduleTypeChanged();
    }
    else if(type == 'schedule')
    {
        $('.tag-fields').addClass('hidden');
        $('.comment-fields').addClass('hidden');

        var val = $("input[name='scheduleType']:checked").val();
        scheduleTypeChanged(val ? val : 'custom');
    }
});

$(function()
{
    $('#repo').change();
    $('#triggerType').change();
});

function scheduleTypeChanged(type)
{
    if(type == 'custom')
    {
        $('.schedule-fields').removeClass('hidden');
        $('.custom-fields').removeClass('hidden');
    }
    else
    {
        $('.schedule-fields').addClass('hidden');
        $('.custom-fields').addClass('hidden');
    }
}
