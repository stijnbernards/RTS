using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using RestServer.webserver.items;
using MySql.Data.MySqlClient;
using System.Web.Script.Serialization;
using RestServer.global;

namespace RestServer.webserver.model
{
    class Towndata : ServerMain
    {
        public Towndata(HttpListenerContext ctx, string[] splitUrl)
        {
            if (CheckAuth(ctx))
            {
                if (4 < splitUrl.Length)
                {
                    string userid;
#if DEBUG
                    userid = "1";
#else
                    userid = Sessions.ConnectedUsers[ctx.Request.Headers["hash"]].ToString();
#endif

                    Tuple<string, string>[] parameters = { 
                                                            new Tuple<string, string>("@id", splitUrl[4]), 
                                                            new Tuple<string, string>("@uid", userid) 
                                                         };

                    MySqlDataReader reader = null;
                    if (5 < splitUrl.Length && splitUrl[5] == "all")
                    {
                        reader = GlobalFunctions.Query("SELECT t.ID, t.owner_ID, t.name, t.coords, t.res1, t.res2, t.res3, t.troops,b.buildings FROM towns_info t, buildings b WHERE t.ID = @id AND t.owner_ID = @uid AND t.buildings = b.ID", parameters);
                    }
                    else
                    {
                        reader = GlobalFunctions.Query("SELECT * FROM `towns_info` WHERE `owner_id` = @uid AND `ID` = @id", parameters);
                    }

                    Town town = null;
                    while (reader.Read())
                    {
                        town = new Town()
                        {
                            ID = reader.GetInt16(0),
                            Owner_ID = reader.GetInt16(1),
                            Name = reader.GetString(2),
                            Coords = reader.GetString(3),
                            Res1 = reader.GetInt16(4),
                            Res2 = reader.GetInt16(5),
                            Res3 = reader.GetInt16(6),
                            Troops = reader.GetInt16(7),
                            Buildings = reader.GetString(8),
                        };
                    }
                    string responseText = new JavaScriptSerializer().Serialize(town);
                    byte[] buf = Encoding.UTF8.GetBytes(responseText);

                    ctx.Response.ContentEncoding = Encoding.UTF8;
                    ctx.Response.ContentType = "application/json";
                    ctx.Response.ContentLength64 = buf.Length;

                    ctx.Response.OutputStream.Write(buf, 0, buf.Length);
                    ctx.Response.Close();
                }
            }
        }
    }
}
