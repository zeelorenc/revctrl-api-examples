/*
 *	RevCTRL (c) API accesser
 *	 Pawn-side
*/

#include 					<a_samp>
#include 					<a_http>
#include 					<zcmd>

#define PROJECT_I				1
#define USER_PROJEC				"IrresistibleDev/SF-CNR" // you can grab it off the API but still it's tedious
#define API_UR					"irresistiblegaming.com/rc_updates.php?id=" #PROJECT_ID

#define DIALOG_CHANGE				4000 // change if you want

// Forward

public OnRevCTRLHTTPResponse(index, response_code, data[]);

// Http Response Callback (OnRevCTRLHTTPResponse)

public OnRevCTRLHTTPResponse(index, response_code, data[]) {
    if (response_code == 200) {
 		return ShowPlayerDialog(index, DIALOG_CHANGES, DIALOG_STYLE_MSGBOX, "{00CCFF}" #USER_PROJECT "{FFFFFF} - RevCTRL", "{FFFFFF}An error has occurred, try again later.", "Okay", "");
    }
	return ShowPlayerDialog(index, DIALOG_CHANGES, DIALOG_STYLE_MSGBOX, "{00CCFF}" #USER_PROJECT "{FFFFFF} - RevCTRL", data, "Okay", "");
}

CMD:updates(playerid, params[]) {
	HTTP(playerid, HTTP_GET, API_URL, "", "OnRevCTRLHTTPResponse");
	return SendClientMessage(playerid, -1, "Reading latest changes from {C0C0C0}www.revctrl.com/" #USER_PROJECT "/latest{FFFFFF}, please wait!");
}
