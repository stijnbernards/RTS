using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.IO;
using System.Xml;
using System.Reflection;
using System.Data;
using MySql.Data.MySqlClient;

namespace RestServer.global
{
    class GlobalFunctions
    {
        public static int GetBuildingLevel(int townID, int buildingID)
        {
            return 1;
        }

        public static MySqlDataReader Query(string query, Tuple<string, string>[] parameters = null)
        {
            MySqlConnection connection = new MySqlConnection();
            connection.ConnectionString = GlobalData.Connstring;
            connection.Open();

            MySqlCommand cmd = connection.CreateCommand();
            cmd.CommandText = query;

            if (parameters != null)
            {
                foreach (Tuple<string, string> param in parameters)
                {
                    cmd.Parameters.AddWithValue(param.Item1, param.Item2);
                }
            }
#if DEBUG
            Console.WriteLine(cmd.CommandText);
#endif
            MySqlDataReader reader = cmd.ExecuteReader();
            return reader;
        }
    }
}
