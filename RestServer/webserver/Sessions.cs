using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace RestServer.webserver
{
    static class Sessions
    {
        public static Dictionary<string, int> ConnectedUsers = new Dictionary<string, int>();
    }
}
