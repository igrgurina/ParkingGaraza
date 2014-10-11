using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;
using ParkingProba.Annotations;

namespace ParkingProba
{
    class Sensor
    {
        public delegate void SensorSignalHandler(object o, EventArgs e);

        /// <summary>
        /// </summary>
        /// <example>OnSensorMade(this, EventArgs.Empty);</example>
        public event SensorSignalHandler OnSensorSignal;

        /// <summary>
        /// Can be called periodically, possibly from separate thread.
        /// </summary>
        public void RaiseEvent()
        {
            OnSensorSignal(this, EventArgs.Empty);
        }

    }
}
