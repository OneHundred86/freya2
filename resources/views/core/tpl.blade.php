<div class="tpl" id="ui-tpl">
	<div class="window-frame modal" data-node="dwArticle">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class=" window-title" data-node="dwTitle">

		</div>
		<div class="content modal-dialog" data-node="dwContent">
			<div class="modal-dialog-title" data-node="articleTitle">
				<h2 data-node="dwTitle"></h2>
				<span class="col right status-item" data-node="dwStatus"></span>
			</div>
			<div class="modal-dialog-row" data-node="dwRow">
				<div class="row-item" data-node="dwType">
					<span class="item-label">所属分类：</span>
					<span class="content-padding" data-node="dwContent">xxxx</span>
				</div>
				<div class="row-item" data-node="dwAccount">
					<span class="item-label">发布账号：</span>
					<span class="content-padding" data-node="dwContent">xxxx</span>
				</div>
				<div class="row-item" data-node="dwUnit">
					<span class="item-label">发布单位：</span>
					<span class="content-padding" data-node="dwContent">xxxx</span>
				</div>
				<div class="row-item" data-node="dwDate">
					<span class="item-label" >发布时间：</span>
					<span data-node="dwContent"></span>
				</div>
			</div>
			<div class="modal-dialog-content" data-node="articleContent">
				<div class="fill-content" data-node="dwContent" style="display: none">

				</div>
				<iframe src="" class="fill-content" data-node="dwUrlContent" style="display: none">

				</iframe>
			</div>
		</div>
		<div class="ctrl modal-dialog-footer cancel-bg" data-node="dwCtrl" style="display: none">
			<div class="btn-middle" data-node="item">
				<div class="button margin-right with-icon right" data-node="dwBtnCancel">
					<span>审核否决</span>
					<i class="icon-remove"></i>
				</div>
				<div class="button blue margin-right with-icon right" data-node="dwBtnOk">
					<i class="icon-ok"></i>
					<span>审核通过</span>
				</div>
			</div>
		</div>
		<div class="other-fix modal-dialog-row" data-node="dwUnpass" style="display: none">
			<div class="row-item" data-node="item">
				<label class="item-label">审核否决原因：</label>
				<span><input id="reason"  type="text"></span>
				<div class="button margin-right with-icon right" data-node="dwBtnReturn">
					<span>返回</span>
					<i class="icon-remove"></i>
				</div>
				<div class="button blue margin-right with-icon right" data-node="dwBtnOk">
					<i class="icon-ok"></i>
					<span>确定</span>
				</div>
			</div>
		</div>
		<div class="modal-split">

		</div>
	</div>
	<div class="item" data-node="dwImageCollectionItem">
		<div class="text" data-node="dwText"></div>
	</div>
	<div class="item" data-node="dwImageListItem">
		<img data-node="dwImg">
		<div class="title" data-node="dwTitle"></div>
		<div class="check" data-node="dwCheck">
			<i class="icon-ok"></i>
		</div>
	</div>
	<table class="table border-tb" data-node="displayTable">
		<thead>
		<tr>
			<th class="td-1-0">编号</th>
			<th class="td-1-0">操作类型</th>
			<th class="td-1-3">操作理由</th>
			<th class="td-4-0 title">操作描述</th>
			<th class="td-1-0">操作账号</th>
			<th class="td-1-6">操作时间</th>
		</tr>
		</thead>
		<tbody data-node="displayTableTbody">
		<tr data-node="displayTableTr" style="display: none">
			<td class="td-2-0 ntd-height-44px" data-node="dwId"></td>
			<td class="td-2-0 ntd-height-44px" data-node="dwType"></td>
			<td class="td-2-0 ntd-height-44px" data-node="dwReason"></td>
			<td class="td-2-0 cancel-omitted ntd-height-44px" data-node="dwDesc"></td>
			<td class="td-2-0 ntd-height-44px" data-node="dwAccount"></td>
			<td class="td-2-0 ntd-height-44px" data-node="dwOpTime"></td>
		</tr>
		</tbody>
	</table>
	<div class="window-frame modal modal-big" data-node="dwLocalSelect">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class=" window-title" data-node="dwTitle">
			操作记录
		</div>
		<div class="content modal-dialog" data-node="dwContent">
			<div class="main-padding" data-node="dwMp">
				<div data-node="dwTable">

				</div>
				<div class="page-bar" data-node="dwPageBar">
					<div class="simple-pages" data-node="dwSimplePage"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="flex-tips" data-node="dwFlexTips">
		<div class="text" data-node="dwText"></div>
	</div>
	<div class="input-tips" data-node="dwInputTips">

	</div>
	<div class="item" data-node="dwInputTipsItem">

	</div>
	<div class="row x1" data-node="dwSimplePage">
		<div class="button right margin-right slim" data-node="dwJump">跳转</div>
		<input class="input right margin-right center slim" data-node="dwInput">
		<div class="button right margin-right with-icon slim" data-node="dwNext">
			<i class="icon-caret-right"></i>
		</div>
		<div class="label free right margin-right slim" data-node="dwLabel">
			1 / 12
		</div>
		<div class="button right margin-right with-icon slim" data-node="dwPrev">
			<i class="icon-caret-left"></i>
		</div>
	</div>
	<div class="date-range-frame" data-node="dwDateRangeFrame">
		<div class="row x1">
			<div class="col left half">
				<div class="label free margin-right right with-icon">
					<span>开始日期</span>
				</div>
			</div>
			<div class="col right half">
				<div class="label free margin-left left with-icon">
					<span>结束日期</span>
				</div>
			</div>
		</div>
		<div class="row" data-node="dwRowCal"></div>
		<div class="row x1 center" data-node="dwRowCtrl">
			<div class="group-center" data-node="dwGroup">
				<div class="button group-left blue slim" data-node="dwBtnOk">
					<span>确定</span>
				</div>
				<div class="button group-right slim" data-node="dwBtnCancel">
					<span>取消</span>
				</div>
			</div>
		</div>
	</div>
	<div class="calendar" data-node="dwCalendar">
		<div class="hd" data-node="dwHd">
			<div class="hor-adj left" data-node="dwLeft">
				<i class="entypo-icon-left-open"></i>
			</div>
			<div class="year" data-node="dwYear">2015</div>
			<div class="ver-adj" data-node="dwVer">
				<div class="adj" data-node="dwUp">
					<i class="entypo-icon-up-open-mini"></i>
				</div>
				<div class="adj" data-node="dwDown">
					<i class="entypo-icon-down-open-mini"></i>
				</div>
			</div>
			<div class="hor-adj right" data-node="dwRight">
				<i class="entypo-icon-right-open"></i>
			</div>
			<div class="month" data-node="dwMonth">8</div>
		</div>
		<div class="week-hd">
			<div class="day">日</div>
			<div class="day">一</div>
			<div class="day">二</div>
			<div class="day">三</div>
			<div class="day">四</div>
			<div class="day">五</div>
			<div class="day">六</div>
		</div>
		<div class="day-table" data-node="dwTable">

		</div>
	</div>
	<div class="window-frame" data-node="dwAlert">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class="title" data-node="dwTitle">
			提示：
		</div>
		<div class="content" data-node="dwContent">
			<div class="text" data-node="dwText"></div>
		</div>
		<div class="ctrl" data-node="dwCtrl">
			<span class="button-frame" data-node="dwBtnFrame">
				<div class="button blue" data-node="dwBtnOk">
					确定
				</div>
			</span>
		</div>
	</div>
	<div class="window-frame" data-node="dwConfirm">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class="title" data-node="dwTitle">
			提示：
		</div>
		<div class="content" data-node="dwContent">
			<div class="text" data-node="dwText"></div>
		</div>
		<div class="ctrl" data-node="dwCtrl">
			<span class="button-frame" data-node="dwBtnFrame">
				<div class="button blue margin-right with-icon" data-node="dwBtnOk">
					<i class="icon-ok"></i>
					<span>确定</span>
				</div>
				<div class="button margin-left with-icon" data-node="dwBtnCancel">
					<span>取消</span>
					<i class="icon-remove"></i>
				</div>
			</span>
		</div>
	</div>
	<div class="window-frame" data-node="dwPrompt">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class="title" data-node="dwTitle">
			请输入：
		</div>
		<div class="content" data-node="dwContent">
			<div class="text" data-node="dwText"></div>
			<input type="text" data-node="dwInput">
			<div class="tip" data-node="dwTip"></div>
		</div>
		<div class="ctrl" data-node="dwCtrl">
			<span class="button-frame" data-node="dwBtnFrame">
				<div class="button blue margin-right with-icon" data-node="dwBtnOk">
					<i class="icon-ok"></i>
					<span>确定</span>
				</div>
				<div class="button margin-left with-icon" data-node="dwBtnCancel">
					<span>取消</span>
					<i class="icon-remove"></i>
				</div>
			</span>
		</div>
	</div>
	<div class="window-frame" data-node="dwSelect">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class="title" data-node="dwTitle">
			请选择：
		</div>
		<div class="content" data-node="dwContent">
			<div class="text" data-node="dwText"></div>
			<div class="select" data-node="dwSelect">
				<div class="option">请选择</div>
			</div>
		</div>
		<div class="ctrl" data-node="dwCtrl">
			<span class="button-frame" data-node="dwBtnFrame">
				<div class="button blue margin-right with-icon" data-node="dwBtnOk">
					<i class="icon-ok"></i>
					<span>确定</span>
				</div>
				<div class="button margin-left with-icon" data-node="dwBtnCancel">
					<span>取消</span>
					<i class="icon-remove"></i>
				</div>
			</span>
		</div>
	</div>
	<div class="day" data-node="dwDateDay"></div>
	<div class="window-frame" data-node="dwDate">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class="title" data-node="dwTitle">
			请选择时间：
		</div>
		<div class="content" data-node="dwContent">
			<div class="row" data-node="dwRowMain">
				<div class="col half left" data-node="dwColLeft">
					<div class="calendar" data-node="dwCalendar">
						<div class="hd" data-node="dwHd">
							<div class="hor-adj left" data-node="dwLeft">
								<i class="entypo-icon-left-open"></i>
							</div>
							<div class="year" data-node="dwYear">2015</div>
							<div class="ver-adj" data-node="dwVer">
								<div class="adj" data-node="dwUp">
									<i class="entypo-icon-up-open-mini"></i>
								</div>
								<div class="adj" data-node="dwDown">
									<i class="entypo-icon-down-open-mini"></i>
								</div>
							</div>
							<div class="hor-adj right" data-node="dwRight">
								<i class="entypo-icon-right-open"></i>
							</div>
							<div class="month" data-node="dwMonth">8</div>
						</div>
						<div class="week-hd">
							<div class="day">日</div>
							<div class="day">一</div>
							<div class="day">二</div>
							<div class="day">三</div>
							<div class="day">四</div>
							<div class="day">五</div>
							<div class="day">六</div>
						</div>
						<div class="day-table" data-node="dwTable">

						</div>
					</div>
				</div>
				<div class="col half right" data-node="dwColRight">
					<div class="row x1" data-node="dwRow1">
						<div class="label free with-icon">
							<i class="icon-calendar"></i>
						</div>
						<div class="button right right blue slim" data-node="dwNow">
							<span>转到现在</span>
						</div>
					</div>
					<div class="hor-split"></div>
					<div class="row x1" data-node="dwRow2">
						<div class="label free right">
							日
						</div>
						<input class="input slim x2d right" data-node="dwDay">
						<div class="label free right">
							月
						</div>
						<input class="input slim x2d right" data-node="dwMon">
						<div class="label free right">
							年
						</div>
						<input class="input slim x2d right" data-node="dwYear">
					</div>
					<div class="row x1" data-node="dwRow3">
						<div class="label free right">
							秒
						</div>
						<input class="input slim x2d right" data-node="dwSec">
						<div class="label free right">
							分
						</div>
						<input class="input slim x2d right" data-node="dwMin">
						<div class="label free right">
							时
						</div>
						<input class="input slim x2d right" data-node="dwHour">
					</div>
				</div>
			</div>
		</div>
		<div class="ctrl" data-node="dwCtrl">
			<span class="button-frame" data-node="dwBtnFrame">
				<div class="button blue margin-right with-icon" data-node="dwBtnOk">
					<i class="icon-ok"></i>
					<span>确定</span>
				</div>
				<div class="button margin-left with-icon" data-node="dwBtnCancel">
					<span>取消</span>
					<i class="icon-remove"></i>
				</div>
			</span>
		</div>
	</div>
</div>