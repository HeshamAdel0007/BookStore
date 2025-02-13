import BackgroundImage from '@/../public/assets/images/bg-form.jpg'
import Link from 'next/link'

const FormLayout = ({ children }) => {
  return (
    <div className="h-screen flex">
      <div
        className="hidden lg:flex w-100vh h-100vh lg:w-1/2 justify-around items-center"
        style={{
          backgroundImage: `url(${BackgroundImage.src})`,
        }}
      >
        <div className="bg-black opacity-20 inset-0 z-0"></div>
        <div className="w-full mx-auto px-20 flex-col items-center space-y-6">
          <h1 className="text-white font-bold text-4xl font-sans">
            Simple App
          </h1>
          <p className="text-white mt-1">The simplest app to use</p>
          <div className="flex justify-center lg:justify-start mt-6">
            <Link
              className="hover:bg-yellow text-yellow hover:text-black hover:-translate-y-1 transition-all duration-500 bg-black text-indigo-800 mt-4 px-4 py-2 rounded-2xl font-bold mb-2"
              href="/"
            >
              Back
            </Link>
          </div>
        </div>
      </div>
      {/* <!---- /Left form  --> */}
      <div className="flex w-full bg-blue-black lg:w-1/2 justify-center items-center space-y-8">
        <div className="w-full px-8 md:px-32 lg:px-24">{children}</div>
      </div>
    </div>
  )
}

export default FormLayout
